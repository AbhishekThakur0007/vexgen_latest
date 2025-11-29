/**
 * Modern Design System - Tailwind CSS Extension
 * 
 * Tailwind configuration extensions for the modern design system.
 * Merge this into your tailwind.config.js when ready to apply the theme.
 * 
 * @version 1.0.0
 * @status NOT YET APPLIED - Configuration Only
 */

export const modernTailwindExtensions = {
	colors: {
		// Primary Colors
		'modern-primary': {
			DEFAULT: 'hsl(var(--modern-primary))',
			foreground: 'hsl(var(--modern-primary-foreground))',
			hover: 'hsl(var(--modern-primary-hover))',
			active: 'hsl(var(--modern-primary-active))',
		},
		
		// Gradient Colors
		'modern-gradient': {
			from: 'hsl(var(--modern-gradient-from))',
			via: 'hsl(var(--modern-gradient-via))',
			to: 'hsl(var(--modern-gradient-to))',
		},
		
		// Secondary Colors
		'modern-secondary': {
			DEFAULT: 'hsl(var(--modern-secondary))',
			foreground: 'hsl(var(--modern-secondary-foreground))',
			hover: 'hsl(var(--modern-secondary-hover))',
		},
		
		// Background Colors
		'modern-background': {
			DEFAULT: 'hsl(var(--modern-background))',
			subtle: 'hsl(var(--modern-background-subtle))',
		},
		'modern-foreground': {
			DEFAULT: 'hsl(var(--modern-foreground))',
			muted: 'hsl(var(--modern-foreground-muted))',
			subtle: 'hsl(var(--modern-foreground-subtle))',
		},
		
		// Surface Colors
		'modern-surface': {
			DEFAULT: 'hsl(var(--modern-surface))',
			elevated: 'hsl(var(--modern-surface-elevated))',
			hover: 'hsl(var(--modern-surface-hover))',
			active: 'hsl(var(--modern-surface-active))',
		},
		
		// Border Colors
		'modern-border': {
			DEFAULT: 'hsl(var(--modern-border))',
			hover: 'hsl(var(--modern-border-hover))',
			focus: 'hsl(var(--modern-border-focus))',
		},
		
		// State Colors
		'modern-success': {
			DEFAULT: 'hsl(var(--modern-success))',
			foreground: 'hsl(var(--modern-success-foreground))',
			bg: 'hsl(var(--modern-success-bg))',
		},
		'modern-error': {
			DEFAULT: 'hsl(var(--modern-error))',
			foreground: 'hsl(var(--modern-error-foreground))',
			bg: 'hsl(var(--modern-error-bg))',
		},
		'modern-warning': {
			DEFAULT: 'hsl(var(--modern-warning))',
			foreground: 'hsl(var(--modern-warning-foreground))',
			bg: 'hsl(var(--modern-warning-bg))',
		},
		'modern-info': {
			DEFAULT: 'hsl(var(--modern-info))',
			foreground: 'hsl(var(--modern-info-foreground))',
			bg: 'hsl(var(--modern-info-bg))',
		},
		
		// Card Colors
		'modern-card': {
			bg: 'hsl(var(--modern-card-bg))',
			foreground: 'hsl(var(--modern-card-foreground))',
			border: 'hsl(var(--modern-card-border))',
		},
		
		// Input Colors
		'modern-input': {
			bg: 'hsl(var(--modern-input-bg))',
			foreground: 'hsl(var(--modern-input-foreground))',
			border: 'hsl(var(--modern-input-border))',
			placeholder: 'hsl(var(--modern-input-placeholder))',
			'focus-border': 'hsl(var(--modern-input-focus-border))',
		},
		
		// Button Colors
		'modern-button': {
			'primary-bg': 'var(--modern-button-primary-bg)',
			'primary-foreground': 'hsl(var(--modern-button-primary-foreground))',
			'secondary-bg': 'hsl(var(--modern-button-secondary-bg))',
			'secondary-foreground': 'hsl(var(--modern-button-secondary-foreground))',
			'secondary-border': 'hsl(var(--modern-button-secondary-border))',
			'secondary-hover-bg': 'hsl(var(--modern-button-secondary-hover-bg))',
			'ghost-bg': 'var(--modern-button-ghost-bg)',
			'ghost-foreground': 'hsl(var(--modern-button-ghost-foreground))',
			'ghost-hover-bg': 'hsl(var(--modern-button-ghost-hover-bg))',
		},
		
		// Navbar Colors
		'modern-navbar': {
			bg: 'hsl(var(--modern-navbar-bg))',
			border: 'hsl(var(--modern-navbar-border))',
			foreground: 'hsl(var(--modern-navbar-foreground))',
			'link-hover': 'hsl(var(--modern-navbar-link-hover))',
			'link-active': 'hsl(var(--modern-navbar-link-active))',
	},
	},
	
	fontFamily: {
		'modern-body': ['var(--modern-font-body)', 'sans-serif'],
		'modern-heading': ['var(--modern-font-heading)', 'sans-serif'],
		'modern-mono': ['var(--modern-font-mono)', 'monospace'],
	},
	
	fontSize: {
		'modern-xs': 'var(--modern-text-xs)',
		'modern-sm': 'var(--modern-text-sm)',
		'modern-base': 'var(--modern-text-base)',
		'modern-lg': 'var(--modern-text-lg)',
		'modern-xl': 'var(--modern-text-xl)',
		'modern-2xl': 'var(--modern-text-2xl)',
		'modern-3xl': 'var(--modern-text-3xl)',
		'modern-4xl': 'var(--modern-text-4xl)',
		'modern-5xl': 'var(--modern-text-5xl)',
	},
	
	lineHeight: {
		'modern-tight': 'var(--modern-leading-tight)',
		'modern-snug': 'var(--modern-leading-snug)',
		'modern-normal': 'var(--modern-leading-normal)',
		'modern-relaxed': 'var(--modern-leading-relaxed)',
	},
	
	fontWeight: {
		'modern-normal': 'var(--modern-weight-normal)',
		'modern-medium': 'var(--modern-weight-medium)',
		'modern-semibold': 'var(--modern-weight-semibold)',
		'modern-bold': 'var(--modern-weight-bold)',
	},
	
	spacing: {
		'modern-0': 'var(--modern-spacing-0)',
		'modern-1': 'var(--modern-spacing-1)',
		'modern-2': 'var(--modern-spacing-2)',
		'modern-3': 'var(--modern-spacing-3)',
		'modern-4': 'var(--modern-spacing-4)',
		'modern-5': 'var(--modern-spacing-5)',
		'modern-6': 'var(--modern-spacing-6)',
		'modern-8': 'var(--modern-spacing-8)',
		'modern-10': 'var(--modern-spacing-10)',
		'modern-12': 'var(--modern-spacing-12)',
		'modern-16': 'var(--modern-spacing-16)',
		'modern-20': 'var(--modern-spacing-20)',
		'modern-24': 'var(--modern-spacing-24)',
	},
	
	borderRadius: {
		'modern-sm': 'var(--modern-radius-sm)',
		'modern-md': 'var(--modern-radius-md)',
		'modern-lg': 'var(--modern-radius-lg)',
		'modern-xl': 'var(--modern-radius-xl)',
		'modern-2xl': 'var(--modern-radius-2xl)',
		'modern-3xl': 'var(--modern-radius-3xl)',
		'modern-full': 'var(--modern-radius-full)',
	},
	
	boxShadow: {
		'modern-xs': 'var(--modern-shadow-xs)',
		'modern-sm': 'var(--modern-shadow-sm)',
		'modern-md': 'var(--modern-shadow-md)',
		'modern-lg': 'var(--modern-shadow-lg)',
		'modern-xl': 'var(--modern-shadow-xl)',
		'modern-2xl': 'var(--modern-shadow-2xl)',
	},
	
	transitionDuration: {
		'modern-base': '200ms',
		'modern-fast': '150ms',
		'modern-slow': '300ms',
	},
	
	transitionTimingFunction: {
		'modern': 'cubic-bezier(0.4, 0, 0.2, 1)',
	},
	
	zIndex: {
		'modern-base': 'var(--modern-z-base)',
		'modern-dropdown': 'var(--modern-z-dropdown)',
		'modern-sticky': 'var(--modern-z-sticky)',
		'modern-fixed': 'var(--modern-z-fixed)',
		'modern-modal-backdrop': 'var(--modern-z-modal-backdrop)',
		'modern-modal': 'var(--modern-z-modal)',
		'modern-popover': 'var(--modern-z-popover)',
		'modern-tooltip': 'var(--modern-z-tooltip)',
	},
};
