    @extends('admin_utama.layout.layout')
    @section('content')
    <script type="text/javascript">
        window.onload = function() {


            var renderButton = document.getElementById("renderButton");
            document.getElementById("varBtn");
            // renderButton.addEventListener("click", addDataPointsAndRender);
            varBtn.addEventListener("click", addHimpunan);
        }
        
             //dataPoints. 
             var nama;
             var i = 0;
             var j = 0;
             var temp;
             var urut = 1;
             var titik = [];
             var varbtn = [];
            var html = '';
            function fix_chart() {
                html += '<input type="hidden" name="banyak_'+urut+'" value='+titik.length+'>';
                       
                        for(var a = 0;a < titik.length;a++ ){
                            var isix = titik[a].x;
                            var isiy = titik[a].y;
                            html += '<input type="hidden" name="banyak'+urut+'x'+a+'" value='+isix+'><br>'+
                            '<input type="hidden" name="banyak'+urut+'y'+a+'" value='+isiy+'>';
                        }
                        html += '<input type="hidden" name="banyak" value='+urut+'>';
                $( "#tampil").html(html);
            }
            function addHimpunan() {
                
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "Input Himpunan Fuzzy serta Batas"
                    },
                    data: varbtn
                });
                nama = document.getElementById("nama").value;
                temp = document.getElementById("temp");

                xValue = Number(document.getElementById("xValue").value);
                yValue = Number(document.getElementById("yValue").value);
                
                if(j == 0){
                    temp.value = nama;
                    titik.push({
                        x: xValue,
                        y: yValue
                    });
                    varbtn.push({
                        name: nama,
                        type: "line",
                        showInLegend: true,
                        dataPoints: titik
                    });
                     html += '<input type="hidden" name="nama_'+urut+'" value="'+nama+'">';

                    j++;
                }else{
                    if(nama == temp.value){
                        titik.push({
                            x: xValue,
                            y: yValue
                        });
                    }else{
                        html += '<input type="hidden" name="banyak_'+urut+'" value="'+titik.length+'">';
                       
                        for(var a = 0;a < titik.length;a++ ){
                            var isix = titik[a].x;
                            var isiy = titik[a].y;
                            html += '<input type="hidden" name="banyak'+urut+'x'+a+'" value="'+isix+'"><br>'+
                            '<input type="hidden" name="banyak'+urut+'y'+a+'" value="'+isiy+'">';
                        }
                        urut++;
                        titik = [];
                        titik.push({
                            x: xValue,
                            y: yValue
                        });
                        varbtn.push({
                            name: nama,
                            type: "line",
                            showInLegend: true,
                            dataPoints: titik
                        });
                        temp.value = nama;
                         html += '<input type="hidden" name="nama_'+urut+'" value="'+nama+'">';
                        i++;
                    }
                }
                html += '<input type="hidden" name="banyak" value="'+urut+'">';
                $( "#tampil").html(html);
            chart.render();
        }

    </script>
    <div class="container">
     <input type="hidden" id="temp">


     <div id="chartContainer" style="height: 270px; width: 100%;">
     </div>


     <br>
     X Value:
     <input id="xValue" type="number" step="any" placeholder="Enter X-Value"> Y Value:
     <input id="yValue" type="number" step="any" placeholder="Enter Y-Value">
     <br>
     <br>
     Nama Himpunan : <input id="nama" type="text" placeholder="Enter Nama Himpunan">
     <br>
     <br>
     <button class="btn btn-info" id="varBtn">Set Himpunan</button>
     
     <hr>
    <form method="POST" action="{{ route('admin_utama_add_himpunan', $id) }}" >
        @csrf
        <div id="tampil" class="col-sm-12" >
        </div>

        <button id="kirim" class="btn btn-success" onclick="fix_chart()" >
            Kirim
        </button>
    </form>
</div>
@endsection
