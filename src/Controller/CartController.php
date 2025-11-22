<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    // (A) Add to cart
    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add(Product $product, Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []); // default []

        $id = $product->getId();
        $cart[$id] = ($cart[$id] ?? 0) + 1;

        $session->set('cart', $cart);

        $this->addFlash('success', 'Produit ajouté ✅');

        return $this->redirectToRoute('client_products');
    }

    // (B) Show cart
    #[Route('/cart', name:'cart_show')]
    public function show(Request $request, ProductRepository $repo): Response
    {
        $cart = $request->getSession()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = $repo->find($id);
            if(!$product) continue;

            $lineTotal = $product->getPrix() * $qty;
            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'lineTotal' => $lineTotal
            ];
            $total += $lineTotal;
        }

        return $this->render('cart/show.html.twig', [
            'items' => $items,
            'total' => $total
        ]);
    }

    // (C) Remove line
    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove(Product $product, Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        unset($cart[$product->getId()]);
        $session->set('cart', $cart);

        $this->addFlash('info', 'Produit supprimé.');

        return $this->redirectToRoute('cart_show');
    }

    // (D) Checkout => create Order + OrderItems + decrement stock
    #[Route('/cart/checkout', name:'cart_checkout')]
    public function checkout(
        Request $request,
        ProductRepository $repo,
        EntityManagerInterface $em
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $session = $request->getSession();
        $cart = $session->get('cart', []);
        if(!$cart){
            $this->addFlash('warning', 'Panier vide.');
            return $this->redirectToRoute('cart_show');
        }

        $order = new Order();
        $order->setUser($this->getUser());
        $order->setDateCreation(new \DateTime());
        $order->setStatus('pending');

        $total = 0;

        foreach($cart as $id => $qty) {
            $product = $repo->find($id);
            if(!$product) continue;

            // check stock
            if($product->getStock() < $qty){
                $this->addFlash('danger', 'Stock insuffisant: '.$product->getNom());
                return $this->redirectToRoute('cart_show');
            }

            $item = new OrderItem();
            $item->setOrders($order);
            $item->setProduct($product);
            $item->setQuantiter($qty);
            $item->setPrixAchat($product->getPrix());

            $lineTotal = $product->getPrix() * $qty;
            $total += $lineTotal;

            // decrement stock
            $product->setStock($product->getStock() - $qty);

            $em->persist($item);
        }

        $order->setMontantTotal($total);

        $em->persist($order);
        $em->flush();

        $session->remove('cart');

        $this->addFlash('success','Commande créée ✅');

        return $this->redirectToRoute('client_orders');
    }
}
