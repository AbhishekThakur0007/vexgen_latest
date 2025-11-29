<div class="modern-feature-card group">
    <div class="flex items-start justify-between gap-4">
        <span class="modern-feature-icon [&_svg]:h-auto [&_svg]:w-5">
            <span class="inline-flex">
                {!! $item->image !!}
            </span>
        </span>
    </div>
    <h6 class="modern-feature-title">
        {!! __($item->title) !!}
    </h6>
    <p class="modern-feature-desc">
        {!! __($item->description) !!}
    </p>
</div>
