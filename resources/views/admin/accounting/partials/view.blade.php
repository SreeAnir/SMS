
  @if( @$accounting==null )
  <!-- Modal -->
  <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="accountModalLabel">Entry Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="view-accounting-body" class="modal-body">
           {{-- details ajaxed here --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @else  
  <div class="card">
    <div class="card-body p-2">
      <p><strong>Category:</strong>  {{ $accounting->category->category_label}}
      @include('common.account-badge' ,[ 'instance' =>  $accounting ])
      </p>
      <p><strong>Branch Location:</strong>  {{ $accounting->location?->name }}</p>
      <!-- Amount -->
      <p><strong>Amount:</strong> {{ priceFormatted( $accounting->amount ) }}</p>

      <!-- Category Badge -->

      <!-- Created Date -->
      <p><strong>Created Date:</strong>  {{ $accounting->date }}</p>

      <p><strong>Remarks :</strong>  {{ $accounting->remarks }}</p>

    </div>

  </div>         
  @endif