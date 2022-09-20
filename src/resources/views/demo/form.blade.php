@php
    declare(strict_types=1);
    use App\Http\ViewResources\Demo\DemoFormViewResource;
    use App\Http\Requests\Demo\DemoFormUpdateRequest;
    use App\Constants\Views\BladeConstants as Constants;
    use \App\Constants\App\AppSystem;
    assert(isset($vr) && $vr instanceof DemoFormViewResource);
@endphp
@extends(match (app_core()->getSystem()) {
        AppSystem::Shop => 'shop.layouts.base',
        AppSystem::Seller => 'seller.layouts.base-id',
        AppSystem::Admin => 'admin.layouts.base-admin',
    })
{{-- 各App Systemごとにデザインを動的に変えるための処理であり、本来は不要 --}}
@section('main_internal')
    <h2 style="margin-top: 16px; font-size: larger; font-weight: bolder">{{ $vr->getTitle() }}</h2>
    <div style="font-size: xx-small">
        <ul>
            <li>デモフォームIDの１の桁が4の場合にNot Found</li>
            <li>デモフォームIDの１の桁が5の場合にInternal Error</li>
            <li>デモフォーム列挙体に青を指定して更新ボタン押すとログイン画面へ</li>
        </ul>

    </div>
    <form
        method="POST"
        style="margin: 8px; border: black 1px solid; padding: 8px"
        action="{{ $vr->getUpdateActionUrl() }}">
        @csrf
        <div>
            <label for="display_order_id">{{ '受注番号' }}</label>
            <input type="text"
                   name="{{ DemoFormUpdateRequest::PARAM_DISPLAY_ORDER_ID }}"
                   id="display_order_id"
                   title="受注番号"
                   placeholder="入力してください"
                   value="{{ $vr->input_display_order_id }}">
            @error(DemoFormUpdateRequest::PARAM_DISPLAY_ORDER_ID)
            <div style="color: red">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="demo_form_enum">{{ 'デモフォーム列挙体' }}</span></label>
            {{
                Form::select(
                    name: DemoFormUpdateRequest::PARAM_DEMO_FORM_ENUM,
                    list: $vr->getDemoFormEnumList(),
                    selected: $vr->input_demo_form_enum,
                    selectAttributes: [
                         'class' => 'my-class',
                         'placeholder' => '選択してください...',
                         'title' => 'デモフォーム列挙体',
                         'id' => 'demo_form_enum',
                         ],
                    optionsAttributes: []
                )
            }}
            @error(DemoFormUpdateRequest::PARAM_DEMO_FORM_ENUM)
            <div style="color: red">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="bank_code">{{ '金融機関コード' }}</span></label>
            <input type="text"
                   name="{{ DemoFormUpdateRequest::PARAM_BANK_CODE }}"
                   id="bank_code"
                   title="金融機関コード"
                   placeholder="入力してください"
                   value="{{ $vr->input_bank_code }}">
            @error(DemoFormUpdateRequest::PARAM_BANK_CODE)
            <div style="color: red">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="bank_account_type">{{ '預金種別' }}</span></label>
            {{
                Form::select(
                    name: DemoFormUpdateRequest::PARAM_BANK_ACCOUNT_TYPE,
                    list: $vr->getBankAccountTypeList(),
                    selected: $vr->input_account_type,
                    selectAttributes: [
                         'class' => 'my-class',
                         'placeholder' => '選択してください...',
                         'title' => '預金種別',
                         'id' => 'bank_account_type',
                         ],
                    optionsAttributes: []
                )
            }}
            @error(DemoFormUpdateRequest::PARAM_BANK_ACCOUNT_TYPE)
            <div style="color: red">{{ $message }}</div>
            @enderror
        </div>

        @error('global')
        <div style="color: red" role="alert"><strong>{{ $message }}</strong></div>
        @enderror

        @if(($message = $vr->session_update_success_message) !== null)
            <div style="color: green" role="alert"><strong>{{ $message }}</strong></div>
        @endif

        <button type="submit">
            {{ '更新' }}
        </button>

    </form>

    <form
        method="POST"
        style="margin: 8px; border: black 1px solid; padding: 8px"
        action="{{ $vr->getClearActionUrl() }}">
        @csrf

        @error('global')
        <div style="color: red" role="alert"><strong>{{ $message }}</strong></div>
        @enderror

        @if(($message = $vr->session_delete_success_message) !== null)
            <div style="color: green" role="alert"><strong>{{ $message }}</strong></div>
        @endif

        <button type="submit">
            {{ '削除' }}
        </button>

    </form>

    <aside>
        <small>{{ $vr->getElapsedMessage() }}</small>
    </aside>


    <aside
        style="
    margin: 32px 8px 16px 8px;
    border: lightgrey 1px solid;
    padding: 8px;
    font-size: small;
    background-color: whitesmoke;
    "
    >
        <p>{{ 'API版のデモ: ' }}</p>
        <ul>
            @foreach ($vr->getApiDemoUActions() as $key => list($method, $url))
                <li>
                    <form method="{{ $method }}"
                          name="{{ 'form_'. $key }}"
                          target="_blank"
                          rel="noopener noreferrer"
                          action="{{ $url }}">
                        @csrf
                        <span>{{ $method.' ' }}<a
                                href="javascript:{{ 'form_'.$key }}.submit()">{{ $url }}</a></span>
                    </form>
                </li>
            @endforeach
        </ul>
        <div>
            <label for="show_csrf">{{ 'CSRF: ' }}</label>
            <input id="show_csrf" type="text" size="50" readonly value="{{ csrf_token() }}"/>
        </div>
    </aside>
@endsection

{{-- 各App Systemごとにデザインを動的に変えるための処理であり、本来は不要 --}}
@if(app_core()->getSystem() === AppSystem::Admin)
    @section(Constants::MAIN_CONTENT_CONTAINER_CLASS, 'dummy_page')
    @section(Constants::MAIN_CONTENT)
        <div class="admin_inner">
            @yield('main_internal')
        </div>
    @endsection
@else
    @section(Constants::CONTENT)
        <div class="content content_bg user_content">
            <div class="inner">
                @yield('main_internal')
            </div>
        </div>
    @endsection
@endif
