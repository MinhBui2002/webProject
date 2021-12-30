<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use App\Entity\Product;
use App\Form\ProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/viewall/" , name = "view_all_product")
     */
    public function viewAllProduct()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render(
            "product/index.html.twig",
            [
                'products' => $products
            ]
        );
    }

    /**
     * @Route("/product/view/{id}", name = "view_product")
     */
    public function viewProduct($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if ($product != null) {
            return $this->render(
                "product/detail.html.twig",
                [
                    'product' => $product
                ]
            );
        } else {
            return $this->redirectToRoute("view_all_product");
        }
    }

    /**
     * @Route("/product/delete/{id}", name = "delete_product_by_id")
     */
    public function deleteProduct($id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if ($product != null) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();
        }
        return $this->redirectToRoute("view_all_product");
    }

    /**
     * @Route("/product/add", name = "add_product")
     */
    public function addProduct(Request $request)
    {
        $product = new Product();
        $productForm = $this->createForm(productType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $image = $product->getProductImage();
            $imgName = uniqid();
            $imgExtension = $image->guessExtension();
            $imageName = $imgName . "." . $imgExtension;
            try {
                $image->move(
                    $this->getParameter('product_image'),
                    $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }
            $product->setProductImage($imageName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute("view_all_product");
        }
        return $this->renderForm(
            "product/add.html.twig",
            [
                'productForm' => $productForm
            ]
        );
    }

    /**
     * @Route("/product/edit/{id}", name = "edit_product")
     */
    public function editProduct(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $productForm = $this->createForm(productType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $file = $productForm['ProductImage']->getData();
            if ($file != null) {
                $image = $product->getProductImage();
                $imgName = uniqid();
                $imgExtension = $image->guessExtension();
                $imageName = $imgName . "." . $imgExtension;
                try {
                    $image->move($this->getParameter('product_image'), $imageName);
                } catch (FileException $e) {
                    throwException($e);
                }
                $product->setProductImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute("view_all_product");
        }
        return $this->renderForm(
            "product/edit.html.twig",
            [
                'productForm' => $productForm
            ]
        );
    }
}