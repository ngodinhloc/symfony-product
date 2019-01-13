<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exceptions\ProductException;
use App\Forms\ProductType;
use App\Repository\ProductRepository;
use App\Services\Constants;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product/list/", name="listProducts", methods="GET")
     * @param Request $request
     * @return Response
     */
    public function listProducts(Request $request)
    {
        $page = $request->get("page") ? $request->get("page") : 1;
        $order = $request->get("order");
        $products = $this->productRepository->getProducts($page, $order);
        return $this->render('list.html.twig', array(
            'products' => $products->getIterator(),
            'total' => ceil($products->count() / Constants::PRODUCT_PER_PAGE),
            'order' => $order,
            'page' => $page
        ));
    }

    /**
     * @Route("product/create/", name="createProduct")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function createProduct(Request $request, FileUploader $fileUploader)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form['picture']->getData();
            try {
                $fileName = $fileUploader->upload($file);
                $product->setPicture($fileName);
            } catch (FileException $exception) {
                throw $exception;
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('listProducts'));
        }

        return $this->render('create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("product/update/", name="updateProduct")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     * @throws ProductException|FileException
     */
    public function updateProduct(Request $request, FileUploader $fileUploader)
    {
        $productId = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $product = $em->find(Product::class, $productId);
        if (!$product) {
            throw new ProductException("Invalid product id");
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            if ($file = $form['picture']->getData()) {
                try {
                    $fileName = $fileUploader->upload($file);
                    $product->setPicture($fileName);
                } catch (FileException $exception) {
                    throw $exception;
                }
            }
            $em->persist($product);
            $em->flush();
            return $this->redirect($this->generateUrl('listProducts'));
        }

        return $this->render('update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("product/view/", name="viewProduct", methods="GET")
     * @param Request $request
     * @return Response
     * @throws ProductException
     */
    public function viewProduct(Request $request)
    {
        $productId = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $product = $em->find(Product::class, $productId);
        if (!$product) {
            throw new ProductException("Invalid product id");
        }
        return $this->render('view.html.twig', array(
            'product' => $product,
        ));
    }

    /**
     * @Route("product/delete/", name="deleteProduct", methods="POST")
     * @param Request $request
     * @return JsonResponse
     * @throws ProductException
     */
    public function deleteProduct(Request $request)
    {
        $productId = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        /** @var Product $product */
        $product = $em->find(Product::class, $productId);
        if (!$product) {
            throw new ProductException("Invalid product id");
        }
        $em->remove($product);
        $em->flush();
        @unlink($this->getParameter("upload_dir") . "/" . $product->getPicture());
        return JsonResponse::create(["result" => 1]);
    }
}