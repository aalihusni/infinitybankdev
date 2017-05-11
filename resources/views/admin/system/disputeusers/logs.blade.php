<span class="pull-left"><strong>Complain By</strong> : {{$Detail->byAlias}}({{$Detail->complain_by}}), <strong>Status:</strong>{{($Detail->statusBy)?' Suspended':' Active'}}</span>
<span class="pull-right"><strong>Complain To</strong>: {{$Detail->toAlias}}({{$Detail->complain_to}}), <strong>Status:</strong>{{($Detail->statusTo)?' Suspended':' Active'}}</span>
<table class="table">
                            <thead>
                            <tr>
                               <th>From</th>
                               <th>Description</th>
                               <th>Link</th>
                               <th>Created At</td>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($logs as $list)
                                        <tr>
                                            <td>{{$list->alias}} </td>
                                            <td>{{$list->description}}</td>
                                             <td>{{$list->transaction_link}}</td>
                                            <td>{{ $list->created_at }}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>