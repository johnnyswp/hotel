
	<div id="header">
             
    		<div class="tools-bar pull-right">
    				
    				<ul class="nav navbar-nav navbar-right tooltip-area " >
    						<li style="width: 200px;" >
                                <div style="background-image: url({{Hotel::find(Hotel::id())->logo}}); height: 46px; display: block; background-size: contain; background-position: right; background-repeat: no-repeat; width: 100%; top: 2px; margin-top: 3px;"></div>
                            </li>
    						<li style="text-transform: uppercase;">
    						    <div class="">
    								@if($user = Sentry::getUser())
    								<a href="{{url('/clinic/admin-profile')}}" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
    									<em><strong>{{Hotel::find(Hotel::id())->name}}</strong></em>
    								</a>
    								@endif
    							</div>	<!-- //dropdown-menu-->
    						</li>
    				</ul>
    		</div>
    		<!-- //tools-bar-->
    		
    </div>