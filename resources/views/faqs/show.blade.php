@extends('layouts.app')

@section('content')

<div class="page-content">
        <div class="portlet light bordered">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('faqs.faq.index') }}">Faqs</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Faq View</span>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="portlet-title">
                        <div class="caption">
                            <h4 class="caption-subject bold uppercase">
                                <i class="fa fa-display"></i>&nbspCreate New Faq
                            </h4>
                        </div>
                    </div>
                    <div class="portlet-body">
                        
                        <div class="accordion" id="accordionExample">
                              <div class="card">
                                <div class="card-header" id="headingOne">
                                  <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                      Collapsible Group Item #1
                                    </button>
                                  </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                  <div class="card-body">
                                            
                                            <div class="card">
                                                <div class="card-header">
                                                  <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                      Collapsible Group Item #2
                                                    </button>
                                                  </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="answer1" data-parent="#accordionExample">
                                                  <div class="card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                  </div>
                                                </div>
                                            </div>
                                  </div>
                                </div>
                              </div>                              
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection