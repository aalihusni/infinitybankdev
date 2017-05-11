@extends('member.default')

@section('title')Network Hierarchy @Stop

@section('nh-class')nav-active @Stop
@section('hierarchy-class')nav-expanded nav-active @Stop

@section('content')

    <script>
        jQuery(document).ready(function() {
            $("#org").jOrgChart({
                chartElement : '#chart',
                dragAndDrop  : true
            });
        });
    </script>
    </head>


    <ul id="org" style="display:none;">
        <li>
            PERSON
            <ul>
                <li>PERSON
                    <ul>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                    </ul></li>
                <li>PERSON
                    <ul>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                    </ul></li>
                <li>PERSON
                    <ul>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                        <li>PERSON
                            <ul>
                                <li>PERSON</li>
                                <li>PERSON</li>
                                <li>PERSON</li>
                            </ul></li>
                    </ul></li>
            </ul>
        </li>
    </ul>

    <div id="chart" class="orgChart"></div>

    <script>
        jQuery(document).ready(function() {

            $('#list-html').text($('#org').html());

            $("#org").bind("DOMSubtreeModified", function() {
                $('#list-html').text('');

                $('#list-html').text($('#org').html());

                prettyPrint();
            });
        });
    </script>

@Stop