    <td colspan="10">

        <table class="table table-striped mb-none">
            <thead>
            <tr>
                <td>{{ trans('gh.assigneddate') }}</td>
                <td>{{ trans('gh.value') }} <span class="fa fa-bitcoin">TC</td>
                <td>{{ trans('gh.status') }}</td>
            </tr>
            </thead>
            <tbody>
            @if (count($gh['phgh']['data']))
                @foreach ($gh['phgh']['data'] as $phgh)
                    <tr>
                        <td>{{ $phgh['created_at'] }}</td>
                        <td>{{ $phgh['value_in_btc'] }}</td>
                        <td>{{ $phgh['status_name'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="center" colspan="4">none</td>
                </tr>
            @endif
            </tbody>
        </table>

    </td>