<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
      
       @php  
            $left_menus = left_menue();

            $current_url  = Request::path();
         @endphp

      <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="sidebar-toggler-wrapper hide">
               <div class="sidebar-toggler">
                  <span></span>
               </div>
            </li>
            
            @if($left_menus && count($left_menus) > 0)
               @foreach($left_menus AS $key => $main_menue)
                  <li class="nav-item start {{ (isset($active_menue) && $active_menue == $main_menue['permission_name']) ? 'active open' : '' }}">
                     <a href="{{ ($main_menue['url'] == '#')?'javascript:void(0)':url($main_menue['url']) }}" class="{{($main_menue['sub_menue'] && count($main_menue['sub_menue']) > 0)?'nav-link nav-toggle':''}}">
                        <i class="{{$main_menue['class']}}"></i>                        
                        <span class="title">{{$main_menue['name']}}</span>   
                        @if(isset($main_menue['sub_menue']) && count($main_menue['sub_menue']) > 0)                        
                        <span class="arrow"></span>
                        @endif                       
                     </a>
                     @if(isset($main_menue['sub_menue']) && count($main_menue['sub_menue']) > 0)
                        <ul class="sub-menu">
                           @foreach($main_menue['sub_menue'] AS $sub_menue)
                              <li class="nav-item start {{ (isset($active_sub_menue) && $active_sub_menue == $sub_menue['permission_name']) ? 'active open' : '' }}">
                                 <a href="{{url($sub_menue['url'])}}" class="nav-link ">
                                    <i class="{{$sub_menue['class']}}"></i>
                                    <span class="title">{{$sub_menue['name']}}</span>
                                 </a>
                              </li>
                           @endforeach                           
                        </ul>
                     @endif
                  </li>
               @endforeach
            @endif  
      </ul>
   </div>
</div>
                
            