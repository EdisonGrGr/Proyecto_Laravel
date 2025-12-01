<template>
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Outer eye shape -->
        <ellipse cx="24" cy="24" rx="22" ry="14" fill="url(#gradient1)" />
        <ellipse cx="24" cy="24" rx="20" ry="12" fill="white" />
        
        <!-- Iris -->
        <circle cx="24" cy="24" r="9" fill="url(#gradient2)" />
        
        <!-- Pupil -->
        <circle cx="24" cy="24" r="5" fill="#1e293b" />
        
        <!-- Light reflection -->
        <circle cx="26" cy="22" r="2" fill="white" opacity="0.8" />
        <circle cx="28" cy="24" r="1" fill="white" opacity="0.6" />
        
        <defs>
            <linearGradient id="gradient1" x1="0" y1="0" x2="48" y2="48">
                <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#6366f1;stop-opacity:1" />
            </linearGradient>
            <radialGradient id="gradient2" cx="50%" cy="50%" r="50%">
                <stop offset="0%" style="stop-color:#60a5fa;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:1" />
            </radialGradient>
        </defs>
    </svg>
</template>
