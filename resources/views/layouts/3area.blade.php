<link rel="stylesheet" href="{{asset('css/3area/city-picker.css')}}">
<script src="{{asset('js/3area/city-picker.data.js')}}"></script>
<script src="{{asset('js/3area/city-picker.js')}}"></script>
<script src="{{asset('js/3area/main.js')}}"></script>
<tr>
    <th>地区</th>
    <td>
        <div class="docs-methods">
            <form class="form-inline">
                <div id="distpicker">
                    <div class="form-group">
                        <div style="position: relative;">
                            <input id="city-picker3" class="self-form" readonly type="text" value="江苏省/常州市/溧阳市" data-toggle="city-picker">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="self-btn self-btn-warn" id="reset" type="button">重置</button>
                        <button class="self-btn self-btn-danger" id="destroy" type="button">确定</button>
                    </div>
                </div>
            </form>
        </div>
    </td>
</tr>