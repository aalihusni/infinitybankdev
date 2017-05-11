    <td colspan="10">

        <table class="table table-striped mb-none">
            @if ($ph['status'] != 3)
                <thead>
                <tr>
                    <td>{{trans('ph.no')}}</td>
                    <td>{{trans('ph.assigned')}}</td>
                    <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
                    <td>{{trans('ph.status')}}</td>
                    <td>{{trans('ph.action')}}</td>
                </tr>
                </thead>
                <tbody>
                @if (count($ph['phgh']['data']) && $ph['phgh']['data'])
                    @foreach ($ph['phgh']['data'] as $phgh)
                        <tr>
                            <td>{{ $phgh['no'] }}</td>
                            <td>{{ $phgh['created_at'] }}</td>
                            <td>{{ $phgh['value_in_btc'] }}</td>
                            <td id="status{{ $phgh['id'] }}">{{ $phgh['status_name'] }}</td>
                            @if ($phgh['status'] == 0)
                                <td>
                                    <a class="phgh_status simple-ajax-modal btn btn-primary btn-block" href="{{URL::to('/')}}/members/phgh/{{ $phgh['id'] }}" id="{{ $phgh['id'] }}">{{trans('ph.pay')}}</a>
                                </td>
                            @else
                                <td>
                                    &nbsp;
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center" colspan="5">none</td>
                    </tr>
                @endif
                </tbody>
            @elseif ($ph['status'] == 3)
                <thead>
                <tr>
                    <td>{{trans('ph.no')}}</td>
                    <td>{{trans('ph.releasedate')}}</td>
                    <td>PH Type</td>
                    <td>{{trans('ph.value')}} <span class="fa fa-bitcoin">TC</td>
                </tr>
                </thead>
                <tbody>
                @if (count($ph['shares']) && $ph['shares'])
                    @foreach ($ph['shares'] as $shares)
                        <tr>
                            <td>{{ $shares['no'] }}</td>
                            <td>{{ $shares['created_at'] }}</td>
                            <td>{{ $shares['shares_type'] }}</td>
                            @if ($shares['debit_value_in_btc'] > 0)
                                <td>{{ $shares['debit_value_in_btc'] }}</td>
                            @else
                                <td>{{ $shares['credit_value_in_btc'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="center" colspan="4">none</td>
                    </tr>
                @endif
                </tbody>
            @endif
        </table>

    </td>