  @if($listing !=null )
  <div class="col-md-6">

  <div class="card shadow-sm bg-white">
                <div class="card-body">
                    <h5 class="card-title mb-0 text-secondary">{{ @$title }} </h5>
                </div>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-info" scope="col">Category</th>
                            <th class="text-info" scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listing as $item)
                         <tr >
                            <td>{{ $item->category->category_label }}</td>
                            <td>{{ priceFormatted($item->total_amount) }}</td>
                        </tr>
                        @endforeach
                       
                      
                    </tbody>
                </table>
            </div>
    @endif
  </div>