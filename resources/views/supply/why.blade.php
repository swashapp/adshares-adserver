<html>
    <head>
        <link href="<?php use Adshares\Common\Domain\ValueObject\SecureUrl;echo SecureUrl::change(
            asset('css/why.css')
        )?>" rel="stylesheet">
    </head>

    <body>
        <div id="container">
            <section id="banner-preview">
                @if ($bannerType === 'image')
                    <img src="{{ $url }}" style="max-width: 300px; max-height: 500px;"/>
                @elseif($bannerType === 'html')
                    <iframe src="{{ $url }}" sandbox="allow-scripts"></iframe>
                @endif
            </section>
            <section id="supply-info">
                <h3>This ad has been generated by {{ $supplyName }} (<a href="{{ $supplyPanelUrl }}">{{ $supplyPanelUrl }}</a>)</h3>
                <ul>
                    <li>Terms: <a href="{{ $supplyTermsUrl }}">{{ $supplyTermsUrl }}</a></li>
                    <li>Policy: <a href="{{ $supplyPrivacyUrl }}">{{ $supplyPrivacyUrl }}</a></li>
                </ul>
                <div id="ad-report">
                    Report inappropriate ad by clicking the link <a href="{{ $supplyBannerReportUrl }}">{{ $supplyBannerReportUrl }}</a>
                    <br />
                    If you own this site, use direct link <a href="{{ $supplyBannerRejectUrl }}">{{ $supplyBannerRejectUrl }}</a>
                </div>
            </section>

            @if ($demand)
            <section id="demand-info">
                <h3>This ad is provided by {{ $demandName  }} (<a href="{{ $demandPanelUrl }}">{{ $demandPanelUrl }})</a></h3>
                <ul>
                    <li>Terms: <a href="{{ $demandTermsUrl }}">{{ $demandTermsUrl }}</a></li>
                    <li>Policy: <a href="{{ $demandPrivacyUrl }}">{{ $demandPrivacyUrl }}</a></li>
                </ul>
            </section>
            @endif

            <section id="adshares">
                <h3>Ecosystem is powered by Adshares</h3>
                <ul>
                    <li>Website: <a href="https://adshares.net">https://adshares.net</a></li>
                    <li>Contact: <a href="mailto:office@adshares.net">office@adshares.net</a></li>
                </ul>
            </section>
        </div>
    </body>
</html>
