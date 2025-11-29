@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __('AI Plagiarism'))
@section('titlebar_title')
    <span class="plagiarism-page-title">
        {{ __('AI Plagiarism') }}
    </span>
@endsection
@section('titlebar_subtitle')
    {{ __('Analyze text, comparing it against a vast database online content to identify potential plagiarism') }}
@endsection

@push('css')
    <style>
        /* Plagiarism Page Background - Matching Dashboard Theme */
        body[data-theme="marketing-bot-dashboard"] .lqd-page-wrapper,
        body[data-theme="marketing-bot-dashboard"] {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1d3a 50%, #0f1729 100%) !important;
            min-height: 100vh;
        }
        
        /* Ensure content appears above stars */
        .lqd-page-wrapper > .lqd-page-container,
        .lqd-page-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Stars background positioning */
        #rocket-stars-plagiarism {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        
        /* Unique Heading Styling - Gradient Text with Glow */
        .plagiarism-page-title {
            display: inline-block;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 40%, #7b2ff7 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease-in-out infinite, text-glow-pulse 3s ease-in-out infinite;
            position: relative;
            text-shadow: 0 0 40px rgba(0, 212, 255, 0.5);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
        
        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        @keyframes text-glow-pulse {
            0%, 100% {
                filter: drop-shadow(0 0 20px rgba(0, 212, 255, 0.6)) 
                        drop-shadow(0 0 30px rgba(123, 47, 247, 0.4));
            }
            50% {
                filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.9)) 
                        drop-shadow(0 0 40px rgba(123, 47, 247, 0.6))
                        drop-shadow(0 0 20px rgba(0, 153, 255, 0.5));
            }
        }
        
        @keyframes twinkle {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }
        
        /* Responsive Heading */
        @media (max-width: 768px) {
            .plagiarism-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .plagiarism-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Card Body Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] .lqd-card [class*="body"],
        body[data-theme="marketing-bot-dashboard"] .lqd-card-body {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
        }
        
        /* Card Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-card,
        body[data-theme="marketing-bot-dashboard"] [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] input,
        body[data-theme="marketing-bot-dashboard"] textarea,
        body[data-theme="marketing-bot-dashboard"] select,
        body[data-theme="marketing-bot-dashboard"] .tinymce {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] input:focus,
        body[data-theme="marketing-bot-dashboard"] textarea:focus,
        body[data-theme="marketing-bot-dashboard"] select:focus,
        body[data-theme="marketing-bot-dashboard"] .tinymce:focus {
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Content Result Area */
        body[data-theme="marketing-bot-dashboard"] #content_result {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Result Items Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-plagiarism-result-item {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-plagiarism-result-item:hover {
            transform: translateY(-2px);
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Chart Container */
        body[data-theme="marketing-bot-dashboard"] #chart-credit {
            background: transparent !important;
        }
        
        /* Sentence highlighting */
        body[data-theme="marketing-bot-dashboard"] .sentence {
            transition: all 0.3s ease;
        }
        
        body[data-theme="marketing-bot-dashboard"] .sentence:hover {
            opacity: 0.9 !important;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .text-heading-foreground,
        body[data-theme="marketing-bot-dashboard"] h3,
        body[data-theme="marketing-bot-dashboard"] h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .text-foreground,
        body[data-theme="marketing-bot-dashboard"] p {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Border styling */
        body[data-theme="marketing-bot-dashboard"] .lg\:border-s {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-plagiarism"></div>
    
    <div class="py-10 relative z-10">
        <div class="lqd-plagiarism-wrap flex flex-wrap justify-between gap-y-5">
            <div class="w-full lg:w-[48%]">
                <form
                    class="flex flex-col gap-5"
                    id="scan_content_form"
                    onsubmit="return sendScanRequest();"
                    enctype="multipart/form-data"
                >
                    <x-card size="xs">
                        <h4 class="my-0">
                            {{ __('Add Content') }}

                            <small
                                class="ms-3 font-normal"
                                id="content_length"
                            >
                                0/5000
                            </small>
                        </h4>
                    </x-card>

                    <x-forms.input
                        class="tinymce h-[600px] border-border"
                        id="content_scan"
                        name="content_scan"
                        rows="20"
                        required
                        type="textarea"
                    />

                    <div
                        class="tinymce hidden h-[600px] overflow-y-scroll rounded-xl border"
                        id="content_result"
                        name="content_result"
                    ></div>

                    <x-button
                        id="scan_btn"
                        size="lg"
                        form="scan_content_form"
                        type="submit"
                        onclick="return sendScanRequest()"
                    >
                        {{ __('Scan for Plagiarism') }}
                    </x-button>
                </form>
            </div>

            <div class="w-full lg:w-[48%] lg:border-s lg:ps-10">
                <h3 class="mb-7 text-center">
                    {{ __('Plagiarism Report') }}
                </h3>

                <div class="relative mb-11">
                    <p class="total_percent absolute left-1/2 top-[calc(50%-5px)] m-0 -translate-x-1/2 text-center text-heading-foreground">
                        <span class="text-[23px] font-bold">0</span>%
                        <br>
                        {{ __('Match') }}
                    </p>
                    <div
                        class="relative [&_.apexcharts-legend-text]:!m-0 [&_.apexcharts-legend-text]:!pe-2 [&_.apexcharts-legend-text]:ps-2 [&_.apexcharts-legend-text]:!text-heading-foreground"
                        id="chart-credit"
                    ></div>
                </div>

                <x-card
                    class="mb-5"
                    size="xs"
                >
                    <h4 class="my-0">
                        {{ __('Result Found') }}
                    </h4>
                </x-card>

                <div class="lqd-plagiarism-results scan_results flex w-full flex-col gap-5"></div>
            </div>
        </div>
    </div>

    <template id="result_template">
        <div class="lqd-plagiarism-result-item flex rounded-2xl px-4 shadow-lg shadow-black/5 dark:shadow-white/[2%]">
            <div class="flex w-4/5 items-center justify-start gap-2 py-4">
                <p class="result_index size-6 m-0 inline-flex shrink-0 items-center justify-center rounded-full bg-heading-foreground/10 text-xs font-medium text-heading-foreground">
                    1
                </p>
                <a
                    class="result_url flex w-full items-center gap-2 truncate text-xs"
                    href="#"
                    target="_blank"
                >
                    <x-tabler-link class="size-4" />
                    <span class="result_url_p">
                        https://themeforest.net/item/...
                    </span>
                </a>
            </div>
            <div class="w-1/5 border-s py-4 text-center">
                <p class="m-0 text-2xs font-medium">{{ __('Match') }}</p>
                <p class="result_percent m-0 text-xs font-bold text-red-500">52%</p>
            </div>
        </div>
    </template>

    <template>
        <span class="hover:bg-red-50">Hello</span>
    </template>

    <div
        class="absolute"
        id="contextMenu"
    >
        <ul class="dropdown-menu block w-[250px] rounded-md border-none p-2 shadow-md">
            <li
                class="flex items-center justify-start p-2 hover:opacity-80"
                id="updateWriting"
            >
                <x-tabler-checks class="size-4" />
                <p class="mx-2 my-0">
                    {{ __('Update Content') }}
                </p>
            </li>
        </ul>
    </div>
@endsection

@push('script')
    <script>
        // Interactive Stars Background for Plagiarism Page
        let plagiarismStars = [];
        let plagiarismMouseX = 0;
        let plagiarismMouseY = 0;
        
        function createPlagiarismStars() {
            const starsContainer = document.getElementById('rocket-stars-plagiarism');
            if (!starsContainer) return;
            
            const starCount = 100;
            plagiarismStars = [];
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'rocket-star interactive-dashboard-star';
                const size = Math.random() * 2 + 1;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 3;
                
                star.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: white;
                    border-radius: 50%;
                    left: ${x}%;
                    top: ${y}%;
                    opacity: ${Math.random() * 0.5 + 0.3};
                    box-shadow: 0 0 ${size * 2}px rgba(0, 212, 255, 0.6),
                                0 0 ${size * 4}px rgba(123, 47, 247, 0.4);
                    animation: twinkle ${duration}s ease-in-out infinite;
                    animation-delay: ${delay}s;
                    transition: all 0.3s ease;
                    pointer-events: none;
                `;
                
                star.dataset.x = x;
                star.dataset.y = y;
                star.dataset.baseOpacity = star.style.opacity;
                star.dataset.baseSize = size;
                
                starsContainer.appendChild(star);
                plagiarismStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-plagiarism');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                plagiarismMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                plagiarismMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updatePlagiarismStars();
            });
            
            // Initialize stars
            updatePlagiarismStars();
        }
        
        function updatePlagiarismStars() {
            plagiarismStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = plagiarismMouseX - starX;
                const dy = plagiarismMouseY - starY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                // Calculate intensity based on distance (closer = brighter)
                const maxDistance = 30;
                const intensity = Math.max(0, 1 - (distance / maxDistance));
                
                // Update star properties
                const baseOpacity = parseFloat(star.dataset.baseOpacity);
                const baseSize = parseFloat(star.dataset.baseSize);
                
                const newOpacity = Math.min(1, baseOpacity + intensity * 0.7);
                const newSize = baseSize + intensity * 2;
                const glowSize = newSize * 3;
                
                star.style.opacity = newOpacity;
                star.style.width = newSize + 'px';
                star.style.height = newSize + 'px';
                star.style.boxShadow = `
                    0 0 ${glowSize}px rgba(0, 212, 255, ${0.6 + intensity * 0.4}),
                    0 0 ${glowSize * 2}px rgba(123, 47, 247, ${0.4 + intensity * 0.3}),
                    0 0 ${glowSize * 3}px rgba(0, 255, 136, ${intensity * 0.2})
                `;
            });
        }
        
        // Initialize stars when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createPlagiarismStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createPlagiarismStars);
        } else {
            createPlagiarismStars();
        }
    </script>
    
    <script>
        var total_percent = 0;
        var chart = undefined;

        function renderChart(percent) {
            const options = {
                series: [percent, 100 - percent],
                labels: [('Plagiarized'), ('Unique')],
                colors: ['#D4534A', '#1CA685'],
                chart: {
                    type: 'donut',
                    height: 205,
                },
                legend: {
                    position: 'bottom',
                    fontFamily: 'inherit',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 90,
                        offsetY: 0,
                        donut: {
                            size: '75%',
                        }
                    },
                },
                grid: {
                    padding: {
                        bottom: -130
                    }
                },
                stroke: {
                    width: 5,
                    colors: 'var(--tblr-body-bg)'
                },
                responsive: [{
                    // breakpoint: 480,
                    options: {
                        chart: {
                            width: 280,
                            height: 250
                        },
                    }
                }],
                dataLabels: {
                    enabled: false,
                }
            };
            if (chart) {
                chart.updateSeries([percent, 100 - percent]);
            } else {
                chart = (new ApexCharts(document.getElementById('chart-credit'), options));
                chart.render();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            "use strict";
            renderChart(total_percent);

        });
    </script>

    <script src="/themes/default/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        var $contextMenu = $("#contextMenu");
        var selectedSentence = undefined;
        $contextMenu.hide();
        $("#content_scan").on('input', function(e) {
            $("#content_length").text($(this).val().length + "/5000");
        })
        $("body").on("contextmenu", ".sentence", function(e) {
            selectedSentence = $(this);
            $contextMenu.css({
                display: "block"
            });
            $contextMenu.css({
                display: "fixed",
                left: e.pageX,
                top: e.pageY
            });
            return false;
        });

        $('html').click(function() {
            $contextMenu.hide();
        });

        $("#updateWriting").click(function(e) {
            let formData = new FormData();
            formData.append('prompt',
                'Rewrite below content unique.');
            formData.append('content', selectedSentence.html());
            Alpine.store('appLoadingIndicator').show();
            $.ajax({
                type: "post",
                url: "/dashboard/user/openai/update-writing",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    selectedSentence.html(data.result);
                    selectedSentence.contents().unwrap();
                    Alpine.store('appLoadingIndicator').hide();
                },
                error: function(data) {
                    Alpine.store('appLoadingIndicator').hide();
                }
            });
        });
    </script>
    <script>
        function sendScanRequest(ev) {
            "use strict";
            ev?.preventDefault();

            if ($("#content_scan").val().length < 80) {
                toastr.warning('The length of content should be bigger than 80 characters.');
                return false;
            }

            var formData = new FormData();

            formData.append('text', $("#content_scan").val());

            Alpine.store('appLoadingIndicator').show();
            $('#scan_btn').prop('disabled', true);

            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                url: "/dashboard/user/openai/plagiarismcheck",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#scan_btn').prop('disabled', false);
                    Alpine.store('appLoadingIndicator').hide();
                    let sources = data.data.report_data.sources;
                    $(".scan_results").empty();

                    for (let i = 0; i < sources.length; i++) {
                        sources[i].index = i;
                    }

                    sources.sort((a, b) => {
                        return b.plagiarism_percent - a.plagiarism_percent;
                    })

                    $("#result_text").text("Result Found(" + Math.max(sources.length, 5) + ")");

                    for (let i = 0; i < sources.length && i < 5; i++) {
                        let resultTemplate = document.querySelector("#result_template").content.cloneNode(true);
                        $(resultTemplate.querySelector('.result_index')).text(i + 1);
                        $(resultTemplate.querySelector('.result_url_p')).text(sources[i].link.name);
                        $(resultTemplate.querySelector('.result_url')).attr('href', sources[i].link.urls[0]);
                        $(resultTemplate.querySelector('.result_percent')).text(sources[i]
                            .plagiarism_percent + "%");
                        $(".scan_results").append(resultTemplate);
                    }
                    if (sources.length == 0) {
                        total_percent = 0;
                    } else {
                        total_percent = sources[0].plagiarism_percent;
                    }
                    renderChart(total_percent);
                    $(".total_percent span").text(total_percent);
                    let nodes = data.data.report_data.nodes;

                    let content = $("#content_scan").text();

                    let reContent = "";

                    function getColorByNumber(number) {
                        const green = Math.floor(255 * (1 - number / 100));
                        const red = Math.floor(255 * number / 100);
                        const rgbColor = `rgba(${red}, ${green}, 0, 0.7)`;

                        return rgbColor;
                    }

                    for (let i = 0; i < nodes.length; i++) {
                        // if (nodes[i].sources.length == 0) {
                        //     reContent += " " + nodes[i].text.replace(/\n/g, "<br>");
                        // } else {
                        let tColor = "#FFC7001A";
                        for (let j = Math.min(5, sources.length) - 1; j >= 0; j--) {
                            for (let k = 0; k < nodes[i].sources.length; k++) {
                                if (nodes[i].sources[k] == sources[j].index) {
                                    tColor = "#FF01011A"
                                }
                            }
                        }
                        reContent += (
                            "<span class='sentence hover:opacity-80 cursor-pointer' style='background-color: " +
                            tColor +
                            "'>" +
                            " " + nodes[i].text.replace(/\n/g, "<br>") +
                            '</span>');
                        // }
                    }
                    reContent += ""
                    $("#content_result").removeClass('hidden');
                    $("#content_result").html(reContent);
                    $("#content_scan").hide();
                    var $contextMenu = $("#contextMenu");
                    $("body").on("contextmenu", ".sentence", function(e) {
                        $contextMenu.css({
                            display: "block"
                        });
                        $contextMenu.css({
                            display: "absolute",
                            left: e.pageX,
                            top: e.pageY
                        });
                        return false;
                    });

                    var formData_ = new FormData();

                    formData_.append('input', $("#content_scan").val());
                    formData_.append('percent', total_percent);
                    formData_.append('text', reContent);

                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        url: "/dashboard/user/openai/plagiarismsave",
                        data: formData_,
                        contentType: false,
                        processData: false,
                        success: function() {

                        }
                    });
                },
                error: function(data) {
                    toastr.warning(data.responseJSON.message);
                    console.log(data);
                    Alpine.store('appLoadingIndicator').hide();
                    $('#scan_btn').prop('disabled', false);
                }
            });
            return false;
        }
    </script>
@endpush
