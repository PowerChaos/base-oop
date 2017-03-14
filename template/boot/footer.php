</div><!--container -->
<div class="text-center col-xs-12"><br>&copy; <a href="https://github.com/PowerChaos/base">PowerChaos</a> 2016 - <?php echo date(Y)?></div>  
</div><!-- /#page-content-wrapper -->
 </div><!-- /#wrapper -->  
		
    
<!-- Modal -->
 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icomoon icon-close" title="Sluiten" aria-hidden="true"></i><span class="sr-only">Sluiten</span></button>
         <h4 class="modal-title" id="myModalLabel">Details</h4>
       </div>
       <div class="modal-body" id="modalcode">
       </div>
    </div>
   </div>
 </div>
<!-- end modal -->
    <!-- Menu Toggle Script -->
<script type="text/javascript">
$(document).ready(function() {
//header DropDown Fix
	$('.dropdown-toggle').click(function(){
		var parent = $(this).parent();
		if(parent.hasClass('open')) { 
			parent.removeClass('open'); 
		} else {
			parent.addClass('open');
		}
	});	
	} );
</script>	
	</body>
</html>