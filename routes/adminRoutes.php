<?php
Route::get('kalamadmin', 'UserController@login')->name('admin');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth', 'namespace' => 'Backend'], function(){

	Route::get('/', 'DashboardController@dashboard')->name('dashboard');

	Route::get('category', 'CategoryController@index')->name('category.list');
	Route::get('category/create', 'CategoryController@create')->name('category.create');
	Route::post('category/store', 'CategoryController@store')->name('category.store');
	Route::get('category/show/{id}', 'CategoryController@show')->name('category.show');
	Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit');
	Route::post('category/update', 'CategoryController@update')->name('category.update');
	Route::get('category/delete/{id}', 'CategoryController@delete')->name('category.delete');

	Route::get('subcategory', 'SubCategoryController@index')->name('subcategory.list');
	Route::get('subcategory/create', 'SubCategoryController@create')->name('subcategory.create');
	Route::post('subcategory/store', 'SubCategoryController@store')->name('subcategory.store');
	Route::get('subcategory/show/{id}', 'SubCategoryController@show')->name('subcategory.show');
	Route::get('subcategory/edit/{id}', 'SubCategoryController@edit')->name('subcategory.edit');
	Route::post('subcategory/update', 'SubCategoryController@update')->name('subcategory.update');
	Route::get('subcategory/delete/{id}', 'SubCategoryController@delete')->name('subcategory.delete');

	Route::prefix('division')->name('division.')->group( function() {
        Route::get('/', 'DeshjureController@division')->name('index');
        Route::post('store', 'DeshjureController@division_store')->name('store');
        Route::get('edit/{id}', 'DeshjureController@division_edit')->name('edit');
        Route::post('update', 'DeshjureController@division_update')->name('update');
        Route::get('delete/{id}', 'DeshjureController@division_delete')->name('delete');
    });
    Route::prefix('district')->name('district.')->group( function() {
        Route::get('/', 'DeshjureController@district')->name('index');
        Route::post('store', 'DeshjureController@district_store')->name('store');
        Route::get('edit/{id}', 'DeshjureController@district_edit')->name('edit');
        Route::post('update', 'DeshjureController@district_update')->name('update');
        Route::get('delete/{id}', 'DeshjureController@district_delete')->name('delete');
    });
    Route::prefix('upzilla')->name('upzilla.')->group( function() {
        Route::get('/', 'DeshjureController@upzilla')->name('index');
        Route::post('store', 'DeshjureController@upzilla_store')->name('store');
        Route::get('edit/{id}', 'DeshjureController@upzilla_edit')->name('edit');
        Route::post('update', 'DeshjureController@upzilla_update')->name('update');
        Route::get('delete/{id}', 'DeshjureController@upzilla_delete')->name('delete');
	});

	Route::get('speciality', 'SpecialityController@index')->name('speciality.list');
	Route::get('speciality/create', 'SpecialityController@create')->name('speciality.create');
	Route::post('speciality/store', 'SpecialityController@store')->name('speciality.store');
	Route::get('speciality/show/{id}', 'SpecialityController@show')->name('speciality.show');
	Route::get('speciality/edit/{id}', 'SpecialityController@edit')->name('speciality.edit');
	Route::post('speciality/update', 'SpecialityController@update')->name('speciality.update');
	Route::get('speciality/delete/{id}', 'SpecialityController@delete')->name('speciality.delete');


 	//Bangla News Route
    Route::get('news/create', 'NewsController@create')->name('news.create');
    Route::get('news/edit/{news_slug}', 'NewsController@edit')->name('news.edit');
   	Route::get('news/list', 'NewsController@index')->name('news.list');
   	Route::get('news/pending', 'NewsController@pending')->name('news.pending');
   	Route::get('news/draft', 'NewsController@draft')->name('news.draft');
 
    //English News Route
    Route::get('english/news/create', 'EnglishNewsController@create')->name('englishNews.create');
    Route::get('english/news/edit/{news_slug}', 'EnglishNewsController@edit')->name('englishNews.edit');
    Route::get('english/news/list', 'EnglishNewsController@index')->name('englishNews.list');
    Route::get('english/news/pending', 'EnglishNewsController@pending')->name('englishNews.pending');
    Route::get('english/news/draft', 'EnglishNewsController@draft')->name('englishNews.draft');


   	//store, update, delete route same both news
   	Route::post('news/store', 'NewsController@store')->name('news.store');
    Route::post('news/update/{id}', 'NewsController@update')->name('news.update');
    Route::get('news/delete/{id}', 'NewsController@delete')->name('news.delete');
    Route::get('news/attachFile/delete/{id}', 'NewsController@deleteAttachFile')->name('deleteAttachFile');

    Route::get('news-slug/create{slug?}', 'NewsController@createSlug')->name('news.slug');
    Route::get('news/selectImage', 'NewsController@selectImage')->name('selectImage');

    Route::get('news/status/{status}', 'NewsController@status')->name('news.status');
    Route::get('breaking_news/{status}', 'NewsController@breaking_news')->name('breaking_news');

    //not use now
    // Route::post('news/image_upload', 'NewsController@image_upload')->name('image_upload');

	Route::prefix('phato')->name('phato.')->group( function(){
	    Route::get('gallery', 'MediaGalleryController@phato_list')->name('gallery');
	    Route::get('create', 'MediaGalleryController@phato_create')->name('create');
	    Route::post('upload', 'MediaGalleryController@phato_upload')->name('upload');
	    Route::get('edit/{id}', 'MediaGalleryController@phato_edit')->name('edit');
	    Route::post('update', 'MediaGalleryController@phato_update')->name('update');
	    Route::get('delete/{id}', 'MediaGalleryController@phato_delete')->name('delete');

	    Route::post('upload/CKEditor', 'MediaGalleryController@phato_uploadCKEditor')->name('phato_uploadCKEditor');
	});

	Route::prefix('video')->name('video.')->group( function(){
	    Route::get('gallery', 'MediaGalleryController@video_list')->name('gallery');
	    Route::get('create', 'MediaGalleryController@video_create')->name('create');
	    Route::post('upload', 'MediaGalleryController@video_upload')->name('upload');
	    Route::get('edit/{id}', 'MediaGalleryController@video_edit')->name('edit');
	    Route::post('update', 'MediaGalleryController@video_update')->name('update');
	    Route::get('delete/{id}', 'MediaGalleryController@video_delete')->name('delete');
	});

	Route::prefix('reporter')->name('reporter.')->group( function(){
	    Route::get('list', 'ReporterController@index')->name('list');
	    Route::get('create', 'ReporterController@create')->name('create');
	    Route::post('store', 'ReporterController@store')->name('store');
	    Route::get('{id}/edit', 'ReporterController@edit')->name('edit');
	    Route::post('update/{id}', 'ReporterController@update')->name('update');
	    Route::get('delete/{id}', 'ReporterController@delete')->name('delete');
	    Route::get('status/{id}', 'ReporterController@reporterStatus')->name('status');
	});	

	Route::prefix('reporter-request')->name('reporterRequest.')->group( function(){
	    Route::get('list', 'ReporterController@manage_request')->name('list');
	    Route::get('rejected/List', 'ReporterController@rejectedList')->name('rejectedList');
	    Route::get('AcceptReject/{status}', 'ReporterController@statusAcceptReject')->name('status');
	  
	});

	Route::prefix('page')->name('page.')->group( function(){
		Route::get('list', 'PageController@list')->name('list');
		Route::get('create', 'PageController@create')->name('create');
		Route::post('store', 'PageController@store')->name('store');
		Route::get('edit', 'PageController@edit')->name('edit');
		Route::get('update', 'PageController@update')->name('update');
		Route::get('delete/{id}', 'PageController@delete')->name('delete');
	});

	Route::prefix('advertisement')->name('addvertisement.')->group( function(){
        Route::get('list', 'AddvertisementController@index')->name('list');
        Route::get('setting', 'AddvertisementController@setting')->name('setting');
		Route::get('create', 'AddvertisementController@create')->name('create');
		Route::post('store', 'AddvertisementController@store')->name('store');
		Route::get('edit/{id}', 'AddvertisementController@edit')->name('edit');
		Route::post('update/{id}', 'AddvertisementController@update')->name('update');
		Route::get('delete/{id}', 'AddvertisementController@delete')->name('delete');
		Route::get('status/{id}', 'AddvertisementController@status')->name('status');

	});

    Route::prefix('setting')->name('setting.')->group( function() {
        Route::get('/', 'SettingController@index')->name('index');
        Route::post('store', 'SettingController@setting_store')->name('store');
        Route::get('edit/{id}', 'SettingController@setting_edit')->name('edit');
        Route::post('update', 'SettingController@setting_update')->name('update');
        Route::get('delete/{id}', 'SettingController@setting_delete')->name('delete');
    });



});


