  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">




      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
	
	
		<li class="{if $controller eq 'index' AND ($action eq 'index')}active{/if}"><a href="/"><i class="fa fa-table"></i> <span>Dashboard</span></a></li>

		<li class="{if $controller eq 'holiday-request' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit' or $action eq 'approved')}active{/if}"><a href="/holiday-request/"><i class="fa fa-table"></i> <span>Leave request</a></li>

		
		<li class="{if $controller eq 'timesheet' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active{/if}"><a href="/timesheet/"><i class="fa fa-table"></i> <span>Time sheet</span></a></li>

		
		<li class="{if $controller eq 'overtime' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit' or $action eq 'approved')}active{/if}"><a href="/overtime/"><i class="fa fa-table"></i> <span>Overtime request</a></li>




		<li class="{if $controller eq 'logwork' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active{/if}"><a href="/logwork/"><i class="fa fa-table"></i> <span>Logwork</a></li>

		<li class="{if $controller eq 'salary' AND $action eq 'index'}active {/if}"><a href="/salary/"><i class="fa fa-table"></i> <span>Salary</span></a></li>
		
		
		
		{if $admin->role eq 2}
		
		<li class="{if $controller eq 'salary' AND $action eq 'setting'}active {/if}"><a href="/salary/setting/"><i class="fa fa-table"></i> <span>Salary Setting</span></a></li>

	
		 
		<li class="{if $controller eq 'holiday' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active{/if}"><a href="/holiday/"><i class="fa fa-table"></i> <span>National holiday</a></li>
				 
		<li class="{if $controller eq 'user' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active{/if}"><a href="/user/"><i class="fa fa-table"></i> <span>Users</a></li>
		
		<li class="{if $controller eq 'accessories' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active {/if}"><a href="/accessories/"><i class="fa fa-table"></i> <span>Accessories</span></a></li>			

		
		{/if}
				
		
		{if $admin->role eq 2 or $admin->position_id eq 5}
		<li class="{if $controller eq 'project' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active {/if}"><a href="/project"><i class="fa fa-table"></i> <span>Project</span></a></li>
		
		<li class="{if $controller eq 'project-effort' AND ($action eq 'index' or $action eq 'add' or $action eq 'edit')}active {/if}"><a href="/project-effort/"><i class="fa fa-table"></i> <span>Project Effort</span></a></li>	
		{/if}
	
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  
