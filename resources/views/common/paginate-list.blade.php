
{{-- listing id shoudl be item-lists 
    --}}
    @push('scripts')
    <script>
        $(() => {  
     
            $(document).ready(function()
            {
                $(document).on('click', '.pagination a',function(event)
                {
                  $('.pagination a li').removeClass('active');
                    $(this).parent('li').addClass('active');
                    event.preventDefault();
            
                    var myurl = $(this).attr('href');
                    var page=$(this).attr('href').split('page=')[1];
            
                    getData(page);
                });
            });
            
            function getData(page){
              let extra_params='';
              
              if (typeof paginateListParams === 'function') {
                extra_params = paginateListParams();
              }else{
                console.log('No extra params');
              }
                $.ajax({
                    url: '?page=' + page+''+extra_params,
                    type: "get",
                    datatype: "html",
                })
                .done(function(data){
                    $("#item-lists").empty().html(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError){
                    alert('No response from server');
                });
            }
        });

      
    </script>

    