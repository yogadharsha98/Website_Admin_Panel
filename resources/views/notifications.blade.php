@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        
        <div class="card">
            <div class="card-header">
                Alerts
            </div>
            <div class="card-body">
                <?php
                $count = 1;
                ?>
                
                @if(!empty($maleGoatAlerts))
                    @foreach($maleGoatAlerts AS $maleGoatAlert)
                    
                        <div class="alert alert-warning col-12">{{$maleGoatAlert->tag_id}} ({{$maleGoatAlert->animal_type}} - {{$maleGoatAlert->breed}} - {{$maleGoatAlert->gender}}) was recorded abnormal weights {{$maleGoatAlert->alert_count}} times in last 3 months </div>
                    
                    
                    @endforeach
                @endif
                
                @if(!empty($femaleGoatAlerts))
                    @foreach($femaleGoatAlerts AS $femaleGoatAlert)
                    
                        <div class="alert alert-warning col-12">{{$femaleGoatAlert->tag_id}} ({{$femaleGoatAlert->animal_type}} - {{$femaleGoatAlert->breed}} - {{$femaleGoatAlert->gender}}) was recorded abnormal weights {{$femaleGoatAlert->alert_count}} times in last 3 months </div>
                    
                    @endforeach
                @endif
                
            </div>
        </div>
        


        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023. UlavarSandhai
                    PVT LTD <a href="" target="_blank">Designed by </a> Sasitharan technologies
                    All rights reserved.</span>
            </div>
        </footer>
    </div>

    
@endsection
