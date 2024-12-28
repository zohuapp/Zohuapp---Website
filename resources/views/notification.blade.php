@include('layouts.app')

@include('layouts.header')

<div class="siddhi-popular">


    <div class="container">

        <div class="transactions-banner p-4 rounded">
            <div class="row align-items-center text-center">
                <div class="col-md-6">
                    <h3 class="font-weight-bold h4 text-light" id="total_notification"></h3>
                </div>

            </div>
        </div>

        <div class="no-result"><img src="{{asset('img/no-result.png')}}"></div>
      

        <div id="append_list1" class="res-search-list"></div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="container mt-4 mb-4 p-0">

                    <div class="data-table_paginate">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item ">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_previous_btn"
                                       onclick="prev()" data-dt-idx="0" tabindex="0">{{trans('lang.previous')}}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                       onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@include('layouts.footer')


@include('layouts.nav') 


<script type="text/javascript">

    var id = user_uuid;
    var ref = database.collection('notifications').where('userId','==',id).orderBy('createdAt', 'desc');
    ref.get().then(async function (snapshots) {
        jQuery("#total_notification").html('{{trans("lang.total")}} {{trans("lang.notification")}} : ' + snapshots.docs.length);
        if (parseInt(snapshots.docs.length) == parseInt(pagesize)) {
            jQuery("#users_table_previous_btn").hide();
            jQuery("#users_table_next_btn").hide();

        }
    })
    var pagesize = 10;
    var offest = 1;
    var end = null;
    var endarray = [];
    var start = null;
    var append_list = '';
    var totalPayment = 0;
    var decimal_digits = 0;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;
        if (currencyData.decimal_digits) {
            decimal_digits = currencyData.decimal_digits;
        }
    });

    $(document).ready(async function () {
        $("#overlay").show();  
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';

        ref.limit(pagesize).get().then(async function (snapshots) {
            if (snapshots != undefined) {
                
                var html = '';
                html = buildHTML(snapshots);
                jQuery("#overlay").hide();

                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.push(snapshots.docs[0]);
                    $("#overlay").hide();
                    $(".no-result").hide();
                }

                if (snapshots.docs.length == 0) {
                    jQuery("#users_table_previous_btn").hide();
                    jQuery("#users_table_next_btn").hide();
                    $(".no-result").show();
                }
               
                

            }

        });

    });


    function buildHTML(snapshots) {
        var html = '';
        var alldata = [];
        var number = [];
        var vendorIDS = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        alldata.forEach(async (listval) => {

            var val = listval;
            var price_val ='';
            var date = val.createdAt.toDate().toDateString();
            var time = val.createdAt.toDate().toLocaleTimeString('en-US');
            checkOrderStatus(val.orderId);
            html = html + '<div class="transactions-list-wrap mt-4"><a href="" class="order_redirect_' + val.orderId +'"><div class="bg-white px-4 py-3 border rounded-lg mb-3 transactions-list-view shadow-sm"><div class="gold-members d-flex align-items-center transactions-list">';
                

            html = html + '<div class="media transactions-list-left"><div class="mr-3 font-weight-bold card-icon"><span><i class="fa fa-credit-card"></i></span></div><div class="media-body"><h6 class="date">' + val.title + '</h6><h6> {{trans("lang.order_id")}} :'+val.orderId+'</h6><p class="text-muted mb-0">'+date+' '+time+'</p><p class="text-muted mb-0">' + val.body + '</p></div></div>';

            html = html + '</div> </div></div></a></div>';


        });

        return html;

    }
    async function checkOrderStatus(orderId){
        await database.collection('orders').where('id','==',orderId).get().then(async function(snapshots){
            if(snapshots.docs.length>0){
                var orderData=snapshots.docs[0].data();
                 if (orderData.status == "InProcess") {
                    view_details = "{{ route('pending_order', ':id')}}";
                }
                else if (orderData.status == "InTransit") {
                    view_details = "{{ route('intransit_order', ':id')}}";
                }
                else {
                    view_details = "{{ route('completed_order', ':id')}}";
                }
                view_details = view_details.replace(':id', 'id=' + orderId);
             
                $('.order_redirect_'+orderId).attr('href',view_details);
               
            }else{
               
                $('.order_redirect_' + orderId).attr('href','javascript:void(0)');

            }
        })
    }
    async function next() {
        if (start != undefined || start != null) {
            jQuery("#overlay").hide();

            listener = ref.startAfter(start).limit(pagesize).get();
            listener.then(async (snapshots) => {

                html = '';
                html = await buildHTML(snapshots);

                jQuery("#overlay").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1]; 

                    if (endarray.indexOf(snapshots.docs[0]) != -1) {
                        endarray.splice(endarray.indexOf(snapshots.docs[0]), 1);
                    }
                    endarray.push(snapshots.docs[0]);
                }
            });
        }
    }

    async function prev() {
        if (endarray.length == 1) {
            return false;
        }
        end = endarray[endarray.length - 2];

        if (end != undefined || end != null) {
            jQuery("#overlay").show();
            listener = ref.startAt(end).limit(pagesize).get();

            listener.then(async (snapshots) => {
                html = '';
                html = await buildHTML(snapshots);
                jQuery("#overlay").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.splice(endarray.indexOf(endarray[endarray.length - 1]), 1);

                    if (snapshots.docs.length < pagesize) {

                        jQuery("#users_table_previous_btn").hide();
                    }

                }
            });
        }
    }


</script>









