<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('invoice', function () {
    return view('invoice');
});

Route::middleware(['auth'])->group(function () {

    Route::resource('user', 'UsersController');

    Route::resource('sale', 'SalesController');
    Route::put('sale/configuration/{configuration}', 'SalesController@configuration')->name('sale.config');

    Route::resource('client', 'ClientsController');
    Route::resource('adress', 'ClientAdressesController');
    Route::resource('contact', 'ClientContactsController');
    Route::resource('agreement', 'ClientAgreementsController');
    Route::resource('debt', 'ClientDebtsController');
    Route::resource('client.file', 'ClientFilesController');
    Route::put('client/configuration/{configuration}', 'ClientsController@configuration')->name('client.config');
    Route::get('client/mail/{client}', 'ClientsController@debtMail')->name('client.debt.mail');
    Route::get('sunat/api', 'ClientsController@sunat');
    Route::get('sunat/contacts', 'ClientsController@contactsBySunat');
    Route::get('reniec/api', 'ClientsController@reniec');
    Route::get('byName/api', 'ClientsController@ByName');
    Route::get('byRuc/api', 'ClientsController@ByRuc');

    Route::resource('budget', 'BudgetsController');
    Route::resource('budgetItem', 'BudgetItemsController');
    Route::put('budget/{budget}/copy', 'BudgetsController@copy')->name('budget.copy');
    Route::get('pdf/budget/{budget}/view', 'BudgetsController@viewPdf')->name('budget.view.pdf');
    Route::get('pdf/budget/{budget}/download', 'BudgetsController@downloadPdf')->name('budget.download.pdf');
    Route::get('mail/budget/{budget}', 'BudgetsController@mail')->name('budget.mail');
    Route::delete('/budget/{budget}/items', 'BudgetsController@destroyItems')->name('budget.destroy.items');
    Route::put('/budget/configuration/{configuration}', 'BudgetsController@configuration')->name('budget.config');

    Route::resource('invoice', 'InvoicesController');
    Route::resource('invoiceItem', 'InvoiceItemsController');
    Route::delete('/invoice/{invoice}/items', 'InvoicesController@destroyItems')->name('invoice.destroy.items');
    Route::put('invoice/{invoice}/copy', 'InvoicesController@copy')->name('invoice.copy');
    Route::get('pdf/invoice/{invoice}/view', 'InvoicesController@viewPdf')->name('invoice.view.pdf');
    Route::get('pdf/invoice/{invoice}/download', 'InvoicesController@downloadPdf')->name('invoice.download.pdf');
    Route::get('mail/invoice/{invoice}', 'InvoicesController@mail')->name('invoice.mail');
    Route::post('invoice/budget', 'InvoicesController@fromBudget')->name('invoice.fromBudget');
    Route::put('/invoice/configuration/{configuration}', 'InvoicesController@configuration')->name('invoice.config');

    Route::resource('ticket', 'TicketsController');
    Route::resource('ticketItem', 'TicketItemsController');
    Route::delete('/ticket/{ticket}/items', 'TicketsController@destroyItems')->name('ticket.destroy.items');
    Route::put('ticket/{ticket}/copy', 'TicketsController@copy')->name('ticket.copy');
    Route::get('pdf/ticket/{ticket}/view', 'TicketsController@viewPdf')->name('ticket.view.pdf');
    Route::get('pdf/ticket/{ticket}/download', 'TicketsController@downloadPdf')->name('ticket.download.pdf');
    Route::get('mail/ticket/{ticket}', 'TicketsController@mail')->name('ticket.mail');
    Route::post('ticket/budget', 'TicketsController@fromBudget')->name('ticket.fromBudget');
    Route::put('/ticket/configuration/{configuration}', 'TicketsController@configuration')->name('ticket.config');

    Route::resource('debitNote', 'DebitNotesController');
    Route::resource('debitNoteItem', 'DebitNoteItemsController');
    Route::delete('/debitNote/{debitNote}/items', 'DebitNotesController@destroyItems')->name('debitNote.destroy.items');
    Route::put('debitNote/{debitNote}/copy', 'DebitNotesController@copy')->name('debitNote.copy');
    Route::get('pdf/debitNote/{debitNote}/view', 'DebitNotesController@viewPdf')->name('debitNote.view.pdf');
    Route::get('pdf/debitNote/{debitNote}/download', 'DebitNotesController@downloadPdf')->name('debitNote.download.pdf');
    Route::get('mail/debitNote/{debitNote}', 'DebitNotesController@mail')->name('debitNote.mail');
    Route::post('debitNote/invoice', 'DebitNotesController@fromInvoice')->name('debitNote.fromInvoice');
    Route::put('/debitNote/configuration/{configuration}', 'DebitNotesController@configuration')->name('debitNote.config');

    Route::resource('creditNote', 'CreditNotesController');
    Route::resource('creditNoteItem', 'CreditNoteItemsController');
    Route::delete('/creditNote/{creditNote}/items', 'CreditNotesController@destroyItems')->name('creditNote.destroy.items');
    Route::put('creditNote/{creditNote}/copy', 'CreditNotesController@copy')->name('creditNote.copy');
    Route::get('pdf/creditNote/{creditNote}/view', 'CreditNotesController@viewPdf')->name('creditNote.view.pdf');
    Route::get('pdf/creditNote/{creditNote}/download', 'CreditNotesController@downloadPdf')->name('creditNote.download.pdf');
    Route::get('mail/creditNote/{creditNote}', 'CreditNotesController@mail')->name('creditNote.mail');
    Route::post('creditNote/invoice', 'CreditNotesController@fromInvoice')->name('creditNote.fromInvoice');
    Route::put('/creditNote/configuration/{configuration}', 'CreditNotesController@configuration')->name('creditNote.config');

    Route::resource('senderGuide', 'SenderGuidesController');
    Route::resource('senderGuideItem', 'SenderGuideItemsController');
    Route::delete('/senderGuide/{senderGuide}/items', 'SenderGuidesController@destroyItems')->name('senderGuide.destroy.items');
    Route::put('senderGuide/{senderGuide}/copy', 'SenderGuidesController@copy')->name('senderGuide.copy');
    Route::get('pdf/senderGuide/{senderGuide}/view', 'SenderGuidesController@viewPdf')->name('senderGuide.view.pdf');
    Route::get('pdf/senderGuide/{senderGuide}/download', 'SenderGuidesController@downloadPdf')->name('senderGuide.download.pdf');
    Route::get('mail/senderGuide/{senderGuide}', 'SenderGuidesController@mail')->name('senderGuide.mail');
    Route::post('senderGuide/invoice', 'SenderGuidesController@fromInvoice')->name('senderGuide.fromInvoice');
    Route::put('/senderGuide/configuration/{configuration}', 'SenderGuidesController@configuration')->name('senderGuide.config');

    Route::resource('good', 'GoodsController');
    Route::resource('goodName', 'GoodNamesController');
    Route::resource('goodDetail', 'GoodDetailsController');
    Route::resource('goodDetailOption', 'GoodDetailOptionsController');
    Route::resource('goodPrice', 'GoodPricesController');
    Route::resource('goodWarehouse', 'GoodWarehousesController');
    Route::resource('goodServiceCategory', 'GoodServiceCategoriesController');
    Route::resource('goodServiceSubCategory', 'GoodServiceSubCategoriesController');
    Route::get('/gooodDetail/options', 'GoodDetailsController@options')->name('client.import');

    Route::get('/client/list', 'UsersController@clientList');
    Route::get('/datatable/clients', 'ClientsController@dataTable');
    Route::post('/client/import', 'ClientsController@import')->name('client.import');
    Route::get('/export/client', 'ClientsController@export')->name('client.export');

// Route::get('/client', 'UserController@index')->name('client.index');
    // Route::get('/client', 'UserController@create')->name('client.create');
    Route::get('{path}', "HomeController@index")->where('path', '([A-z\d-\/_.]+)?');
});
