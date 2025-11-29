@extends('panel.layout.app', ['disable_tblr' => true])
@section('title', __($openai->title))
@if($openai->type === 'voiceover' || $openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value || $openai->slug === 'ai_speech_to_text')
@section('titlebar_title')
    <span class="voiceover-generator-page-title">
        {{ __($openai->title) }}
    </span>
@endsection
@endif
@section('titlebar_subtitle', __($openai->description))

@if($openai->type === 'voiceover' || $openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value || $openai->slug === 'ai_speech_to_text')
@push('css')
    <style>
        /* Content Manager Modal Styling */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal {
            background: rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(5px);
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-card,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(0, 212, 255, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-card-body {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Close Button */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal button[wire\\:click="closeModal"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 29, 58, 0.95)) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal button[wire\\:click="closeModal"]:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Title Styling */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal h2 {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 700 !important;
        }
        
        /* Filter Tabs/Buttons */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal ul button,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="filter"] button {
            background: rgba(10, 14, 39, 0.6) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal ul button:hover,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="filter"] button:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal ul button.lqd-is-active,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="filter"] button.lqd-is-active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
        
        /* Search Input */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal input[type="text"],
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [id*="search"] {
            background: rgba(10, 14, 39, 0.8) !important;
            border: 1px solid rgba(0, 212, 255, 0.25) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border-radius: 0.5rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal input[type="text"]:focus,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [id*="search"]:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3) !important;
            background: rgba(10, 14, 39, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Sort Dropdown */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="dropdown"] button,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [role="menu"] {
            background: rgba(10, 14, 39, 0.95) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="dropdown"] button:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Dropdown Menu Items */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [role="menu"] button,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-sort-list button {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border: none !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [role="menu"] button:hover,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-sort-list button:hover {
            background: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [role="menu"] button[class*="bg-foreground"],
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-sort-list button[class*="bg-foreground"] {
            background: rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Upload Area */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="drop-area"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
            border: 2px dashed rgba(0, 212, 255, 0.3) !important;
            border-radius: 1.5rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="drop-area"]:hover,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="drop-area"][class*="border-blue"] {
            border-color: rgba(0, 212, 255, 0.5) !important;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 
                        0 0 15px rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Image/Video Cards */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="grid"] > div {
            background: rgba(10, 14, 39, 0.6) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="grid"] > div:hover {
            background: rgba(10, 14, 39, 0.9) !important;
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3), 
                        0 0 10px rgba(0, 212, 255, 0.2) !important;
            transform: translateY(-2px);
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="grid"] > div[class*="outline"] {
            outline-color: rgba(0, 212, 255, 0.6) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Buttons */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal button[type="button"],
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal button[type="button"]:hover,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal .lqd-button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4) !important;
            transform: translateY(-2px);
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal p,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal span,
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal div[class*="text-gray"] {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="text-heading-foreground"] {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Empty State Icons */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="opacity-50"] svg {
            color: rgba(255, 255, 255, 0.4) !important;
        }
        
        /* Borders */
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="border"],
        body[data-theme="marketing-bot-dashboard"] #mediaManagerModal [class*="border-t"] {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Voiceover Generator Page Background - Matching Dashboard Theme */
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
        #rocket-stars-voiceover-generator,
        #rocket-stars-voice-isolator,
        #rocket-stars-speech-to-text {
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
        .voiceover-generator-page-title {
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
            .voiceover-generator-page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .voiceover-generator-page-title {
                font-size: 1.75rem;
            }
        }
        
        /* Card Body Background Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .lqd-card,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="body"] {
            background: transparent !important;
            background-color: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator:hover {
            transform: translateY(-2px) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Form Inputs Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator input,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator textarea,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator select,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="input"],
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="select"] {
            background: rgba(10, 14, 39, 0.9) !important;
            border: 1px solid rgba(0, 212, 255, 0.25) !important;
            border-radius: 0.5rem !important;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator textarea:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator select:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="input"]:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="select"]:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3), 
                        inset 0 1px 2px rgba(0, 212, 255, 0.1) !important;
            background: rgba(10, 14, 39, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator input::placeholder,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Title Input Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #workbook_title {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #workbook_title:focus {
            border-color: rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Speech Items Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .speech {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.2) !important;
            border-radius: 0.75rem !important;
            padding: 1.25rem !important;
            margin-bottom: 1rem !important;
            transition: all 0.3s ease !important;
            backdrop-filter: blur(5px);
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .speech:hover {
            border-color: rgba(0, 212, 255, 0.4) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3), 
                        0 0 15px rgba(0, 212, 255, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transform: translateY(-2px);
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
        }
        
        /* Border Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .border-t {
            border-color: rgba(0, 212, 255, 0.2) !important;
        }
        
        /* Text Colors */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .text-heading-foreground,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator h3,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator h4 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .text-foreground,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator p {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Label Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator label,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="label"] {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Dropdown/Select Options */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator select option {
            background: rgba(10, 14, 39, 0.98) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Icon Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator svg,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [class*="icon"] {
            color: rgba(0, 212, 255, 0.8) !important;
        }
        
        /* Results Section */
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table {
            position: relative;
            z-index: 10;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .lqd-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
        }
        
        /* File Picker Label Styling for Isolator and Speech to Text */
        body[data-theme="marketing-bot-dashboard"] .lqd-filepicker-label,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.8) 0%, rgba(26, 29, 58, 0.8) 50%, rgba(15, 23, 41, 0.8) 100%) !important;
            border: 2px dashed rgba(0, 212, 255, 0.3) !important;
            border-radius: 0.75rem !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-filepicker-label:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card:hover {
            border-color: rgba(0, 212, 255, 0.5) !important;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95) 0%, rgba(26, 29, 58, 0.95) 50%, rgba(15, 23, 41, 0.95) 100%) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 
                        0 0 15px rgba(0, 212, 255, 0.2) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-filepicker-label p,
        body[data-theme="marketing-bot-dashboard"] .lqd-filepicker-label span,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card p,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card span {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Generator Wrap Styling for Speech to Text */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap {
            position: relative;
            z-index: 10;
        }
        
        /* Generator Cards Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-remaining-credits,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-remaining-credits:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card:hover {
            transform: translateY(-2px) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Form Inputs in Generator Cards */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card input,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card textarea,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card select {
            background: rgba(10, 14, 39, 0.9) !important;
            border: 1px solid rgba(0, 212, 255, 0.25) !important;
            border-radius: 0.5rem !important;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card input:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card textarea:focus,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card select:focus {
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3), 
                        inset 0 1px 2px rgba(0, 212, 255, 0.1) !important;
            background: rgba(10, 14, 39, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card input::placeholder,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Labels in Generator Cards */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card label,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-remaining-credits label,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card h5 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Buttons in Generator Cards */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card button,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card [type="submit"] {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-options-card [type="submit"]:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5), 
                        0 0 20px rgba(123, 47, 247, 0.3) !important;
            transform: translateY(-2px) !important;
        }
        
        /* Results/Workbook Area Styling for Speech to Text */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap [class*="workbook"],
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap [class*="result"],
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap .lqd-card {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap .lqd-card:hover {
            transform: translateY(-2px) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25) !important;
        }
        
        /* Text Colors in Generator Wrap */
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap h5,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap h4,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap h3,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap h2 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap p,
        body[data-theme="marketing-bot-dashboard"] .lqd-generator-wrap span {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Heading Styling for Isolator */
        body[data-theme="marketing-bot-dashboard"] h2.font-bold {
            color: rgba(255, 255, 255, 0.9) !important;
            position: relative;
            z-index: 10;
            margin-bottom: 1rem !important;
            margin-top: 2rem !important;
        }
        
        /* Audio Files Card Styling */
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .lqd-card,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="card"] {
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98) 0%, rgba(26, 29, 58, 0.98) 50%, rgba(15, 23, 41, 0.98) 100%) !important;
            background-color: transparent !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            border-radius: 1rem !important;
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 
                        0 0 20px rgba(0, 212, 255, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s ease !important;
            position: relative;
            z-index: 10;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table:hover {
            transform: translateY(-2px) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5), 
                        0 0 30px rgba(0, 212, 255, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .lqd-card-body,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="body"] {
            background: transparent !important;
            background-color: transparent !important;
        }
        
        /* Table Styling inside Audio Files Card */
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table table,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .lqd-table {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table th,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table thead th {
            background: rgba(10, 14, 39, 0.6) !important;
            border-color: rgba(0, 212, 255, 0.2) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table td,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table tbody td {
            background: transparent !important;
            border-color: rgba(0, 212, 255, 0.15) !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table tr:hover,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table tbody tr:hover {
            background: rgba(0, 212, 255, 0.1) !important;
        }
        
        /* Links and Buttons inside Audio Files Card */
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table a,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table button {
            color: rgba(0, 212, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table a:hover,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table button:hover {
            color: rgba(0, 212, 255, 1) !important;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5) !important;
        }
        
        /* Pagination Styling */
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .pagination,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="pagination"] {
            background: transparent !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .pagination .page-link,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="pagination"] a {
            background: rgba(10, 14, 39, 0.8) !important;
            border-color: rgba(0, 212, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .pagination .page-link:hover,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="pagination"] a:hover {
            background: rgba(0, 212, 255, 0.2) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(0, 212, 255, 1) !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table .pagination .page-item.active .page-link,
        body[data-theme="marketing-bot-dashboard"] #generator_sidebar_table [class*="pagination"] .active a {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Button Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator button,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .lqd-button,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [type="submit"],
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [type="button"] {
            transition: all 0.3s ease !important;
            border-radius: 0.5rem !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .lqd-button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [type="submit"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [type="button"]:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4) !important;
        }
        
        /* Generate Button Styling */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #generate_speech_button,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [id*="generate"],
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #openai_generator_button {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border: 1px solid rgba(0, 212, 255, 0.4) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 600 !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #generate_speech_button:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator [id*="generate"]:hover,
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator #openai_generator_button:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.4), rgba(123, 47, 247, 0.4)) !important;
            border-color: rgba(0, 212, 255, 0.6) !important;
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.5), 
                        0 0 20px rgba(123, 47, 247, 0.3) !important;
        }
        
        /* Add New Button */
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .add-new-text {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(123, 47, 247, 0.2)) !important;
            border: 1px solid rgba(0, 212, 255, 0.3) !important;
            color: rgba(0, 212, 255, 0.9) !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease !important;
        }
        
        body[data-theme="marketing-bot-dashboard"] .lqd-voiceover-generator .add-new-text:hover {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(123, 47, 247, 0.3)) !important;
            border-color: rgba(0, 212, 255, 0.5) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3) !important;
        }
    </style>
@endpush
@endif

@section('content')
    @if($openai->type === 'voiceover')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-voiceover-generator"></div>
    @endif
    @if($openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value)
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-voice-isolator"></div>
    @endif
    @if($openai->slug === 'ai_speech_to_text')
    {{-- Animated Stars Background --}}
    <div class="rocket-stars-background" id="rocket-stars-speech-to-text"></div>
    @endif
    @php

        $view = match (true) {
            $openai->type === 'image' => 'panel.user.openai.components.generator_image',
            $openai->type === 'video' => 'panel.user.openai.components.generator_video',
            $openai->type === 'voiceover' => 'panel.user.openai.components.generator_voiceover',
            $openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value => 'ai-voice-isolator::generator_voice_isolator',
            $openai->type === 'video-to-video' && \App\Helpers\Classes\MarketplaceHelper::isRegistered('ai-video-to-video') => 'ai-video-to-video::component',
            default => 'panel.user.openai.components.generator_others',
        };
    @endphp
    <div class="py-10">
        @includeIf($view)
    </div>
    
    {{-- XP Notification Component --}}
    @include('marketing-bot-dashboard.components.xp-notification')
@endsection

@push('script')
    <script>
        var sayAs = '';
    </script>
    <script src="{{ custom_theme_url('/assets/js/panel/openai_generator.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/fslightbox/fslightbox.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/wavesurfer/wavesurfer.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/js/panel/tinymce-theme-handler.js') }}"></script>
    <script src="{{ custom_theme_url('/assets/js/panel/voiceover.js') }}"></script>

    @includeWhen($openai->type === 'voiceover' || $openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value, 'panel.user.openai.scripts.voiceover-isolator')

    @includeWhen($openai->type === 'code', 'panel.user.openai.scripts.code')

    @includeWhen($openai->type !== 'video-to-video', 'panel.user.openai.scripts.common')
    
    @if($openai->type === 'voiceover')
    <script>
        // Interactive Stars Background for Voiceover Generator Page
        let voiceoverGeneratorStars = [];
        let voiceoverGeneratorMouseX = 0;
        let voiceoverGeneratorMouseY = 0;
        
        function createVoiceoverGeneratorStars() {
            const starsContainer = document.getElementById('rocket-stars-voiceover-generator');
            if (!starsContainer) return;
            
            const starCount = 100;
            voiceoverGeneratorStars = [];
            
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
                voiceoverGeneratorStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-voiceover-generator');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                voiceoverGeneratorMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                voiceoverGeneratorMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateVoiceoverGeneratorStars();
            });
            
            // Initialize stars
            updateVoiceoverGeneratorStars();
        }
        
        function updateVoiceoverGeneratorStars() {
            voiceoverGeneratorStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = voiceoverGeneratorMouseX - starX;
                const dy = voiceoverGeneratorMouseY - starY;
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
            createVoiceoverGeneratorStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createVoiceoverGeneratorStars);
        } else {
            createVoiceoverGeneratorStars();
        }
    </script>
    @endif
    
    @if($openai->type === \App\Domains\Entity\Enums\EntityEnum::ISOLATOR->value)
    <script>
        // Interactive Stars Background for Voice Isolator Page
        let voiceIsolatorStars = [];
        let voiceIsolatorMouseX = 0;
        let voiceIsolatorMouseY = 0;
        
        function createVoiceIsolatorStars() {
            const starsContainer = document.getElementById('rocket-stars-voice-isolator');
            if (!starsContainer) return;
            
            const starCount = 100;
            voiceIsolatorStars = [];
            
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
                voiceIsolatorStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-voice-isolator');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                voiceIsolatorMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                voiceIsolatorMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateVoiceIsolatorStars();
            });
            
            // Initialize stars
            updateVoiceIsolatorStars();
        }
        
        function updateVoiceIsolatorStars() {
            voiceIsolatorStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = voiceIsolatorMouseX - starX;
                const dy = voiceIsolatorMouseY - starY;
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
            createVoiceIsolatorStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createVoiceIsolatorStars);
        } else {
            createVoiceIsolatorStars();
        }
    </script>
    @endif
    
    @if($openai->slug === 'ai_speech_to_text')
    <script>
        // Interactive Stars Background for Speech to Text Page
        let speechToTextStars = [];
        let speechToTextMouseX = 0;
        let speechToTextMouseY = 0;
        
        function createSpeechToTextStars() {
            const starsContainer = document.getElementById('rocket-stars-speech-to-text');
            if (!starsContainer) return;
            
            const starCount = 100;
            speechToTextStars = [];
            
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
                speechToTextStars.push(star);
            }
            
            // Track mouse movement
            document.addEventListener('mousemove', function(e) {
                const starsContainer = document.getElementById('rocket-stars-speech-to-text');
                if (!starsContainer) return;
                
                const rect = starsContainer.getBoundingClientRect();
                speechToTextMouseX = ((e.clientX - rect.left) / rect.width) * 100;
                speechToTextMouseY = ((e.clientY - rect.top) / rect.height) * 100;
                
                updateSpeechToTextStars();
            });
            
            // Initialize stars
            updateSpeechToTextStars();
        }
        
        function updateSpeechToTextStars() {
            speechToTextStars.forEach(star => {
                const starX = parseFloat(star.dataset.x);
                const starY = parseFloat(star.dataset.y);
                
                // Calculate distance from mouse
                const dx = speechToTextMouseX - starX;
                const dy = speechToTextMouseY - starY;
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
            createSpeechToTextStars();
        });
        
        // Re-initialize if content is loaded dynamically
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', createSpeechToTextStars);
        } else {
            createSpeechToTextStars();
        }
    </script>
    @endif
@endpush
