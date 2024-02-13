@if($transaction!=null)
<div class="card-body p-3">
                <div class="card-body border-none">
                    <div class="col-lg-12  col-sm-12">
                        @if( @$transaction?->test_mode)
                        <p class="text-center  text-success">Test mode</p>
                        @endif
                        <table class="table table-borderless ">
                            <tbody>
                                <tr>
                                    <td colspan="2" scope="col">
                                        <h6 class="text-muted text-underline"> 
                                           Transaction Info 
                                        </h6>
                                    </td>

                                </tr>
                                
                               
                                <tr>
                                    <td class="text-muted" scope="col" width="40%">Order Reference</td>
                                    <td scope="col">{{ @$transaction?->order_id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted" scope="col">Amount</td>
                                    <td scope="col">{{ priceFormatted (@$transaction?->amount) }} </td>

                                </tr>
                                <tr>
                                    <td class="text-muted" scope="col">Description</td>
                                    <td scope="col">{{ @$transaction?->description }}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted" scope="col">Time</td>
                                    <td scope="col">{{ @$transaction?->updated_at }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <p>
                You will receive an email shortly with details about this transaction. Please verify the information, and feel free to reach out to us if you have any queries or concerns.
                </p>
                <p>
                   <b> Team {{ env('APP_NAME')}}</b>
                </p>
            </div>
            @endif