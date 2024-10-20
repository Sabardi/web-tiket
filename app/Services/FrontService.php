<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;

class frontService
{
    protected $ticketRepository;
    protected $categoryRepository;
    protected $sellerRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository,
    CategoryRepositoryInterface $categoryRepository, SellerRepositoryInterface $sellerRepository) 
    {
        $this->categoryRepository = $categoryRepository;
        $this->ticketRepository = $ticketRepository;
        $this->sellerRepository = $sellerRepository;
    }

    public function getFrontPageData()
    {
        $popularTickets = $this->ticketRepository->getPopularTickets(4);
        $categories = $this->categoryRepository->getAllCategories();
        $sellers = $this->sellerRepository->getAllSellers();
        $newTickets = $this->ticketRepository->getAllNewTickets();

        return compact('popularTickets','categories', 'sellers', 'newTickets');
    }
}
