<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Inertia\Inertia;

class SubscribtionInvoiceController
{
    public function index()
    {

        return Inertia::render(config('route.subscriptioninvoice.index'));
    }
}
