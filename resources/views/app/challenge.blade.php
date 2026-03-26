@extends('app.layout')

@section('content')
<style>
    :root {
        --bg-soft: #f5f9ff;
        --bg-soft-2: #edf4ff;
        --ink-strong: #173763;
        --ink-muted: #5c7398;
        --line-soft: rgba(137, 166, 208, 0.36);
        --card-shadow: 0 14px 30px rgba(17, 36, 65, 0.12);
        --focus-dim: rgba(25, 52, 92, 0.09);
        --radius-main: 18px;
        --radius-soft: 12px;
    }

    .challenge-page {
        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
        padding: 0.4rem 0.25rem 1rem;
        overflow-x: clip;
    }

    .challenge-shell {
        position: relative;
        width: 100%;
        overflow-x: clip;
    }

    /* Interaction fix:
       focus overlay is visual-only and never captures mouse/touch events. */
    .focus-dim-layer {
        position: fixed;
        inset: 0;
        z-index: 72;
        opacity: 0;
        background: var(--focus-dim);
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .challenge-shell.focus-active .focus-dim-layer {
        opacity: 1;
    }

    .challenge-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: minmax(0, 1fr);
        align-items: start;
    }

    @media (min-width: 1040px) {
        .challenge-grid {
            grid-template-columns: 2fr 1fr;
            align-items: start;
        }
    }

    .challenge-card {
        position: relative;
        z-index: 1;
        width: 100%;
        background: linear-gradient(175deg, #fcfeff, var(--bg-soft) 55%, var(--bg-soft-2));
        border: 1px solid var(--line-soft);
        border-radius: var(--radius-main);
        box-shadow: var(--card-shadow);
        padding: 1rem;
        overflow: hidden;
    }

    .challenge-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.8rem;
    }

    .challenge-title {
        margin: 0;
        font-size: clamp(1.05rem, 4.4vw, 1.35rem);
        color: var(--ink-strong);
        font-weight: 800;
    }

    .challenge-subtitle {
        margin: 0.35rem 0 0;
        color: var(--ink-muted);
        font-size: 0.9rem;
    }

    .focus-exit-top {
        border: 1px solid rgba(115, 144, 185, 0.42);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        color: #2f4f83;
        padding: 0.4rem 0.78rem;
        font-size: 0.76rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .focus-exit-top:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 14px rgba(32, 56, 96, 0.14);
    }

    .setup-grid {
        margin-top: 0.95rem;
        display: grid;
        gap: 0.72rem;
        grid-template-columns: 1fr;
    }

    @media (min-width: 760px) {
        .setup-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .field-card {
        border: 1px solid rgba(137, 166, 208, 0.34);
        border-radius: var(--radius-soft);
        background: rgba(255, 255, 255, 0.84);
        padding: 0.7rem;
    }

    .field-label {
        display: block;
        margin-bottom: 0.34rem;
        font-size: 0.875rem;
        color: #345584;
        font-weight: 700;
    }

    .field-help {
        margin: 0.35rem 0 0;
        font-size: 0.875rem;
        color: #5f779d;
    }

    .text-input,
    .pick-object-btn {
        width: 100%;
        box-sizing: border-box;
        min-height: 44px;
        border: 1px solid rgba(122, 154, 198, 0.52);
        border-radius: 10px;
        background: #ffffff;
        color: #18355f;
        font-size: 0.9rem;
        padding: 0.58rem 0.72rem;
        transition: all 0.3s ease;
    }

    .text-input:focus,
    .pick-object-btn:focus {
        outline: none;
        border-color: #6d9eef;
        box-shadow: 0 0 0 3px rgba(109, 158, 239, 0.16);
    }

    .pick-object-btn {
        text-align: left;
        font-weight: 700;
        cursor: pointer;
    }

    .focus-stage {
        margin-top: 0.95rem;
        width: 100%;
        min-height: clamp(310px, 55vh, 390px);
        border: 1px solid rgba(142, 171, 212, 0.34);
        border-radius: 16px;
        background:
            radial-gradient(circle at 18% 0%, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.76) 40%, rgba(236, 244, 255, 0.74)),
            linear-gradient(170deg, rgba(244, 249, 255, 0.9), rgba(236, 243, 255, 0.82));
        display: grid;
        grid-template-rows: auto auto 1fr;
        justify-items: center;
        align-items: start;
        padding: 0.95rem;
        position: relative;
        overflow: hidden;
    }

    .focus-stage::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 14px;
        transform: translateX(-50%);
        width: 150px;
        height: 22px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(53, 78, 119, 0.22), rgba(53, 78, 119, 0));
        pointer-events: none;
    }

    .timer-display {
        margin: 0;
        width: 100%;
        text-align: center;
        overflow-wrap: anywhere;
        font-size: clamp(2.25rem, 14vw, 5.4rem);
        line-height: 0.97;
        font-weight: 900;
        color: #1b4ca4;
        letter-spacing: 0.03em;
        text-shadow: 0 8px 16px rgba(31, 75, 160, 0.14);
    }

    .timer-display.pulse {
        animation: timerPulse 0.2s ease;
    }

    .object-caption {
        margin: 0.36rem 0 0;
        font-size: 0.81rem;
        color: #5f779d;
        font-weight: 700;
    }

    .visual-object {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: end center;
    }

    .visual-shell {
        width: min(320px, 90%);
        height: min(270px, 94%);
        border-radius: 20px;
        border: 1px solid rgba(144, 170, 211, 0.26);
        background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.9), rgba(232, 242, 255, 0.82));
        display: flex;
        justify-content: center;
        align-items: flex-end;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 0 16px rgba(255, 255, 255, 0.55);
    }

    /* Candle */
    .candle-wrap {
        position: relative;
        width: 96px;
        height: 190px;
        margin-bottom: 20px;
        transform-origin: bottom center;
        transition: all 0.3s ease;
    }

    .candle-body {
        position: absolute;
        inset: auto 0 0;
        margin: 0 auto;
        width: 80px;
        height: 174px;
        border-radius: 28px 28px 16px 16px;
        border: 1px solid rgba(190, 118, 19, 0.58);
        background: linear-gradient(180deg, #fff7de 0%, #ffe2a1 40%, #f8ba5c 76%, #e99631 100%);
        box-shadow: inset -10px -12px 18px rgba(188, 118, 26, 0.24), inset 8px 10px 14px rgba(255, 255, 255, 0.62), 0 7px 14px rgba(116, 71, 12, 0.18);
        overflow: hidden;
    }

    .candle-body::before {
        content: '';
        position: absolute;
        top: 7px;
        left: 50%;
        transform: translateX(-50%);
        width: 72%;
        height: 11px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.54);
    }

    .candle-wax {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(255, 251, 236, 0.92), rgba(255, 219, 140, 0.76), rgba(246, 171, 59, 0.88));
        transition: all 0.3s ease;
    }

    .candle-drip {
        position: absolute;
        width: 10px;
        border-radius: 999px;
        bottom: 18px;
        background: linear-gradient(180deg, #fff3c7, #f0a944);
        box-shadow: inset -2px -2px 5px rgba(165, 94, 14, 0.3);
        transition: all 0.3s ease;
    }

    .candle-drip.left {
        left: 9px;
        height: calc(10px + (var(--melt-level) * 26px));
    }

    .candle-drip.right {
        right: 11px;
        height: calc(12px + (var(--melt-level) * 30px));
    }

    .candle-wick {
        position: absolute;
        left: 50%;
        top: 7px;
        transform: translateX(-50%);
        width: 3px;
        height: 15px;
        border-radius: 999px;
        background: #38332f;
        z-index: 4;
    }

    .candle-flame {
        position: absolute;
        left: 50%;
        top: -4px;
        transform: translateX(-50%);
        width: 22px;
        height: 36px;
        border-radius: 56% 56% 72% 72%;
        background: radial-gradient(circle at 50% 72%, #ff9b41 0%, #ff7830 52%, #e54f17 100%);
        filter: drop-shadow(0 0 11px rgba(255, 140, 56, 0.62));
        transform-origin: center bottom;
        animation: flameFlicker 1.05s ease-in-out infinite;
        z-index: 5;
        transition: all 0.3s ease;
    }

    .candle-flame::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 26%;
        transform: translateX(-50%);
        width: 8px;
        height: 13px;
        border-radius: 50%;
        background: rgba(255, 247, 215, 0.95);
    }

    /* Ice */
    .ice-wrap {
        width: 116px;
        height: 116px;
        margin-bottom: 22px;
        border-radius: 24px;
        border: 1px solid rgba(150, 206, 252, 0.86);
        background: linear-gradient(145deg, rgba(247, 252, 255, 0.9), rgba(177, 226, 255, 0.68) 48%, rgba(120, 205, 249, 0.6) 100%);
        box-shadow:
            inset -12px -14px 20px rgba(33, 116, 170, 0.22),
            inset 10px 11px 18px rgba(255, 255, 255, 0.75),
            0 8px 16px rgba(30, 110, 165, 0.2),
            0 0 16px rgba(137, 208, 255, 0.25);
        position: relative;
        overflow: hidden;
        transform-origin: bottom center;
        transition: all 0.3s ease;
    }

    .ice-wrap::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 17px;
        width: 48px;
        height: 22px;
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0));
        transform: rotate(-12deg);
    }

    .ice-wrap::after {
        content: '';
        position: absolute;
        inset: 10px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.52);
    }

    /* Hot Water */
    .water-wrap {
        position: relative;
        width: 126px;
        height: 156px;
        margin-bottom: 18px;
    }

    .water-cup {
        width: 100%;
        height: 138px;
        border: 2px solid rgba(143, 167, 204, 0.82);
        border-top: 0;
        border-radius: 0 0 27px 27px;
        position: absolute;
        left: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(252, 254, 255, 0.94), rgba(233, 241, 252, 0.88));
        overflow: hidden;
        box-shadow: inset -10px -13px 17px rgba(143, 167, 204, 0.22), inset 10px 11px 15px rgba(255, 255, 255, 0.72);
    }

    .water-cup::before {
        content: '';
        position: absolute;
        top: -11px;
        left: 50%;
        transform: translateX(-50%);
        width: 132px;
        height: 19px;
        border-radius: 999px;
        border: 2px solid rgba(143, 167, 204, 0.82);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(233, 241, 252, 0.88));
    }

    .water-handle {
        position: absolute;
        right: -24px;
        top: 47px;
        width: 21px;
        height: 50px;
        border: 3px solid rgba(143, 167, 204, 0.82);
        border-left: 0;
        border-radius: 0 21px 21px 0;
    }

    .water-fill {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(180, 234, 255, 0.95), rgba(108, 197, 240, 0.9) 45%, rgba(39, 145, 206, 0.92));
        transition: all 0.3s ease;
    }

    .water-fill::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 10px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.62), rgba(255, 255, 255, 0));
    }

    .water-wave {
        position: absolute;
        top: -7px;
        left: -14%;
        width: 128%;
        height: 12px;
        border-radius: 100%;
        background: rgba(226, 247, 255, 0.64);
        animation: waterRipple 2.2s ease-in-out infinite;
    }

    .steam {
        position: absolute;
        top: -34px;
        width: 11px;
        height: 27px;
        border-radius: 50%;
        background: rgba(228, 236, 248, 0.88);
        filter: blur(0.2px);
        animation: steamRise 2.2s ease-in-out infinite;
        transition: all 0.3s ease;
    }

    .steam.s1 { left: 24px; animation-delay: 0s; }
    .steam.s2 { left: 44px; animation-delay: 0.5s; }
    .steam.s3 { left: 62px; animation-delay: 0.95s; }
    .steam.s4 { left: 82px; animation-delay: 1.32s; }

    body.mobile-menu-open .challenge-shell,
    body.mobile-menu-open .focus-modal,
    body.mobile-menu-open .focus-dim-layer {
        pointer-events: none;
    }

    .action-row {
        margin-top: 0.95rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.6rem;
    }

    .btn {
        border: none;
        border-radius: 12px;
        min-height: 44px;
        padding: 0.62rem 0.96rem;
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 9px 15px rgba(29, 53, 91, 0.2);
    }

    .btn:active {
        transform: scale(0.95);
    }

    .btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-start { background: linear-gradient(140deg, #28b871, #1f965a); }
    .btn-pause { background: linear-gradient(140deg, #f0aa46, #df8e27); }
    .btn-end { background: linear-gradient(140deg, #3d7deb, #2a63c7); }
    .btn-reset { background: linear-gradient(140deg, #758ab0, #5a7096); }
    .btn-dark { background: linear-gradient(140deg, #3c4f71, #2c3f5e); }
    .btn-save { width: 100%; background: linear-gradient(140deg, #2f78e8, #295fbe); }

    .status-row {
        margin-top: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3rem 0.66rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(135, 164, 204, 0.42);
        color: #3d5e8f;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .status-dot {
        width: 11px;
        height: 11px;
        border-radius: 999px;
        transition: all 0.3s ease;
    }

    .status-dot.ready { background: #8ca2c3; box-shadow: 0 0 0 4px rgba(140, 162, 195, 0.2); }
    .status-dot.running { background: #2aa46d; box-shadow: 0 0 0 4px rgba(42, 164, 109, 0.2); }
    .status-dot.paused { background: #e39a2b; box-shadow: 0 0 0 4px rgba(227, 154, 43, 0.2); }
    .status-dot.finished { background: #2e69da; box-shadow: 0 0 0 4px rgba(46, 105, 218, 0.2); }

    .complete-panel {
        margin-top: 0.9rem;
        border: 1px solid rgba(109, 182, 130, 0.42);
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(239, 255, 245, 0.95), rgba(224, 249, 235, 0.9));
        color: #1f6b41;
        padding: 0.88rem;
        animation: panelIn 0.32s ease;
    }

    .complete-panel h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
    }

    .complete-panel p {
        margin: 0.34rem 0 0;
        font-size: 0.86rem;
    }

    .panel-actions {
        margin-top: 0.7rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.52rem;
    }

    .save-form {
        margin-top: 0.9rem;
        border: 1px solid rgba(138, 168, 208, 0.34);
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.84);
        padding: 0.82rem;
    }

    .form-field {
        margin-bottom: 0.68rem;
    }

    .helper-note {
        margin-top: 0.72rem;
        color: #60789f;
        font-size: 0.78rem;
    }

    .history-title {
        margin: 0;
        color: var(--ink-strong);
        font-size: 1rem;
        font-weight: 800;
    }

    .history-subtitle {
        margin: 0.35rem 0 0.7rem;
        color: #60789f;
        font-size: 0.875rem;
    }

    .history-list {
        display: grid;
        gap: 0.55rem;
    }

    .history-item {
        border: 1px solid rgba(140, 168, 206, 0.32);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.86);
        padding: 0.58rem;
    }

    .history-topic {
        margin: 0;
        color: #1f3f6f;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .history-meta {
        margin: 0.25rem 0 0;
        color: #61799f;
        font-size: 0.875rem;
    }

    .history-empty {
        margin: 0;
        color: #61799f;
        font-size: 0.875rem;
    }

    .hidden {
        display: none;
    }

    .focus-modal {
        position: fixed;
        inset: 0;
        z-index: 96;
        background: rgba(18, 45, 84, 0.15);
        display: grid;
        place-items: center;
        padding: 1rem;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    .focus-modal.is-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .focus-modal-panel {
        width: min(640px, 100%);
        position: relative;
        z-index: 97;
        border-radius: 18px;
        border: 1px solid rgba(143, 171, 210, 0.4);
        background: linear-gradient(170deg, rgba(253, 255, 255, 0.98), rgba(243, 248, 255, 0.96));
        box-shadow: 0 16px 30px rgba(15, 34, 65, 0.2);
        padding: 0.95rem;
    }

    .focus-options {
        display: grid;
        gap: 0.6rem;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .focus-option {
        border-radius: 11px;
        border: 1px solid rgba(132, 164, 206, 0.44);
        background: rgba(255, 255, 255, 0.9);
        color: #1f3f6f;
        padding: 0.62rem 0.5rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .focus-option:hover {
        transform: scale(1.04);
    }

    .focus-option:active {
        transform: scale(0.96);
    }

    .focus-option.active {
        border-color: #3f79db;
        box-shadow: 0 0 0 3px rgba(63, 121, 219, 0.18);
        background: rgba(237, 245, 255, 0.95);
    }

    .focus-preview {
        margin-top: 0.8rem;
        min-height: 214px;
        border-radius: 13px;
        border: 1px dashed rgba(132, 164, 206, 0.54);
        background: rgba(255, 255, 255, 0.62);
        display: grid;
        place-items: center;
    }

    .focus-modal-actions {
        margin-top: 0.85rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.55rem;
    }

    body.challenge-focus-mode {
        overflow: hidden;
    }

    body.challenge-focus-mode .challenge-shell.focus-active {
        position: fixed;
        inset: 0;
        z-index: 74;
        display: grid;
        place-items: center;
        padding: 1rem;
    }

    body.challenge-focus-mode .challenge-shell.focus-active .challenge-grid {
        width: min(940px, 100%);
    }

    body.challenge-focus-mode .challenge-shell.focus-active .challenge-card {
        z-index: 74;
        background: #fbfeff;
        border-color: rgba(145, 169, 205, 0.42);
    }

    body.challenge-focus-mode .challenge-shell.focus-active .history-card {
        display: none;
    }

    @media (max-width: 380px) {
        .challenge-page {
            padding: 0.4rem 0.25rem 0.9rem;
        }

        .focus-stage {
            min-height: 290px;
            padding: 0.75rem;
        }

        .timer-display {
            font-size: clamp(1.95rem, 11.5vw, 3.2rem);
        }

        .candle-wrap {
            width: 78px;
            height: 154px;
            margin-bottom: 14px;
        }

        .candle-body {
            width: 66px;
            height: 140px;
        }

        .ice-wrap {
            width: 92px;
            height: 92px;
            margin-bottom: 16px;
        }

        .water-wrap {
            width: 102px;
            height: 128px;
            margin-bottom: 14px;
        }

        .water-cup {
            height: 116px;
        }

        .water-cup::before {
            width: 106px;
        }

        .water-handle {
            right: -18px;
            top: 40px;
            width: 16px;
            height: 44px;
        }

        .steam {
            top: -30px;
            width: 9px;
            height: 22px;
        }

        .steam.s1 { left: 19px; }
        .steam.s2 { left: 34px; }
        .steam.s3 { left: 49px; }
        .steam.s4 { left: 64px; }

        .action-row {
            gap: 0.4rem;
        }

        .action-row .btn {
            flex: 1 1 calc(50% - 0.2rem);
            min-width: 0;
            padding: 0.58rem 0.62rem;
            font-size: 0.84rem;
        }

        .focus-modal {
            padding: 0.65rem;
        }

        .focus-modal-panel {
            padding: 0.72rem;
        }
    }

    @media (max-width: 880px) {
        .focus-options {
            grid-template-columns: 1fr;
        }

        .focus-modal-actions {
            justify-content: stretch;
        }

        .focus-modal-actions .btn {
            flex: 1;
        }

        body.challenge-focus-mode .challenge-shell.focus-active {
            padding: 0.7rem;
        }
    }

    @media (min-width: 320px) {
        .challenge-page {
            padding: 0.45rem 0.35rem 0.95rem;
        }

        .challenge-card {
            padding: 0.88rem;
        }

        .action-row {
            justify-content: stretch;
        }

        .action-row .btn {
            flex: 1 1 calc(50% - 0.6rem);
        }
    }

    @media (min-width: 480px) {
        .challenge-page {
            padding: 0.55rem 0.5rem 1rem;
        }

        .challenge-card {
            padding: 0.95rem;
        }

        .action-row {
            justify-content: center;
        }

        .action-row .btn {
            flex: 0 1 auto;
            min-width: 112px;
        }
    }

    @media (min-width: 768px) {
        .challenge-page {
            padding: 0.6rem 0.75rem 1rem;
        }

        .challenge-card {
            padding: 1rem;
        }

        .challenge-subtitle,
        .field-label,
        .field-help,
        .history-subtitle,
        .history-topic,
        .history-meta,
        .history-empty,
        .btn,
        .text-input,
        .pick-object-btn {
            font-size: 0.9rem;
        }
    }

    @media (min-width: 1280px) {
        .challenge-page {
            max-width: 1180px;
        }
    }

    @keyframes timerPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }

    @keyframes flameFlicker {
        0% { transform: translateX(-50%) scale(1) rotate(-1deg); opacity: 0.9; }
        50% { transform: translateX(-50%) scale(1.11) rotate(2deg); opacity: 1; }
        100% { transform: translateX(-50%) scale(0.96) rotate(-1deg); opacity: 0.92; }
    }

    @keyframes steamRise {
        0% { transform: translateY(0) scale(0.9); opacity: 0.35; }
        100% { transform: translateY(-18px) scale(1.1); opacity: 0; }
    }

    @keyframes waterRipple {
        0% { transform: translateX(0) scaleY(1); }
        50% { transform: translateX(4px) scaleY(1.2); }
        100% { transform: translateX(0) scaleY(1); }
    }

    @keyframes panelIn {
        0% { opacity: 0; transform: translateY(8px) scale(0.97); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>

<div class="challenge-page">
    <div id="challengeShell" class="challenge-shell">
        <div id="focusDimLayer" class="focus-dim-layer" aria-hidden="true"></div>

        <div class="challenge-grid">
            <article class="challenge-card">
                <div class="challenge-head">
                    <div>
                        <h2 class="challenge-title">Focus Challenge</h2>
                        <p class="challenge-subtitle">Challenge tetap gratis tanpa limit sesi. Batas hanya untuk fitur AI.</p>
                    </div>
                    <button id="exitFocusTopBtn" type="button" class="focus-exit-top hidden">Exit Focus Mode</button>
                </div>

                <div class="setup-grid">
                    <div class="field-card">
                        <label for="setMinutesInput" class="field-label">Durasi sesi (menit)</label>
                        <input id="setMinutesInput" type="number" min="1" max="600" value="10" class="text-input">
                        <p class="field-help">Durasi sesi challenge tetap bebas untuk semua user.</p>
                    </div>
                    <div class="field-card">
                        <label class="field-label">Visual fokus</label>
                        <button id="pickObjectBtn" type="button" class="pick-object-btn">Pilih visual fokus</button>
                        <p id="objectHelper" class="field-help">Belum ada visual dipilih.</p>
                    </div>
                </div>

                <section class="focus-stage" aria-live="polite">
                    <h3 id="timerDisplay" class="timer-display">10:00</h3>
                    <p class="object-caption">Objek aktif: <span id="selectedObjectLabel">-</span></p>
                    <div id="visualObject" class="visual-object"></div>
                </section>

                <div class="action-row">
                    <button id="startBtn" type="button" class="btn btn-start">Start</button>
                    <button id="pauseBtn" type="button" class="btn btn-pause" disabled>Pause</button>
                    <button id="endBtn" type="button" class="btn btn-end" disabled>Akhiri</button>
                    <button id="resetBtn" type="button" class="btn btn-reset">Reset</button>
                    <button id="exitFocusBtn" type="button" class="btn btn-dark hidden">Exit Focus Mode</button>
                </div>

                <div class="status-row" aria-live="polite">
                    <span id="statusDot" class="status-dot ready"></span>
                    <span>Status:</span>
                    <span id="statusText">Ready</span>
                </div>

                <div id="completePanel" class="complete-panel hidden" role="status" aria-live="polite">
                    <h3>🎉 Sesi fokus selesai!</h3>
                    <p id="completeText">Durasi tercatat: 0 menit.</p>
                    <div class="panel-actions">
                        <button id="showSaveFormBtn" type="button" class="btn btn-end">Simpan Sesi</button>
                        <button id="exitFocusPanelBtn" type="button" class="btn btn-dark">Exit Focus Mode</button>
                    </div>
                </div>

                <form
                    id="saveSessionForm"
                    action="{{ route('challenge.sessions.store') }}"
                    method="POST"
                    class="save-form {{ $errors->any() ? '' : 'hidden' }}"
                >
                    @csrf
                    <div class="form-field">
                        <label for="topicInput" class="field-label">Judul Challenge</label>
                        <input id="topicInput" name="topic" value="{{ old('topic') }}" class="text-input" placeholder="Contoh: Deep work fisika 45 menit" required>
                    </div>
                    <div class="form-field">
                        <label for="minutesInput" class="field-label">Durasi tersimpan (menit)</label>
                        <input id="minutesInput" type="number" name="minutes" min="1" max="600" value="{{ old('minutes', 10) }}" class="text-input" required>
                    </div>
                    <button type="submit" class="btn btn-save">Simpan Sesi Challenge</button>
                </form>

                <p class="helper-note">Komentar teknis: progress objek dihitung dari sisa_waktu/total_waktu untuk animasi yang halus dan sinkron.</p>
            </article>

            <aside class="challenge-card history-card">
                <h3 class="history-title">Riwayat Challenge</h3>
                <p class="history-subtitle">Sesi terbaru kamu tersimpan di sini.</p>

                <div class="history-list">
                    @forelse ($recentSessions as $session)
                        <div class="history-item">
                            <p class="history-topic">{{ $session->topic ?: 'Focus challenge' }}</p>
                            <p class="history-meta">{{ $session->minutes }} menit • {{ $session->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @empty
                        <p class="history-empty">Belum ada sesi challenge.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
</div>

<div id="focusObjectModal" class="focus-modal hidden" role="dialog" aria-modal="true" aria-labelledby="focusObjectTitle">
    <div class="focus-modal-panel">
        <h3 id="focusObjectTitle" class="history-title">Pilih Visual Fokus</h3>
        <p class="history-subtitle">Visual akan berubah sesuai progress timer.</p>

        <div class="focus-options">
            <button type="button" class="focus-option" data-object="candle">Candle</button>
            <button type="button" class="focus-option" data-object="ice">Ice</button>
            <button type="button" class="focus-option" data-object="hot-water">Hot Water</button>
        </div>

        <div id="focusPreview" class="focus-preview">
            <p class="history-empty">Pilih visual untuk preview.</p>
        </div>

        <div class="focus-modal-actions">
            <button id="cancelFocusBtn" type="button" class="btn btn-reset">Batal</button>
            <button id="confirmFocusBtn" type="button" class="btn btn-end" disabled>Pakai Visual</button>
        </div>
    </div>
</div>

<script>
(() => {
    const timerDisplay = document.getElementById('timerDisplay');
    const statusText = document.getElementById('statusText');
    const statusDot = document.getElementById('statusDot');
    const setMinutesInput = document.getElementById('setMinutesInput');
    const pickObjectBtn = document.getElementById('pickObjectBtn');
    const objectHelper = document.getElementById('objectHelper');
    const selectedObjectLabel = document.getElementById('selectedObjectLabel');
    const visualObject = document.getElementById('visualObject');
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const endBtn = document.getElementById('endBtn');
    const resetBtn = document.getElementById('resetBtn');
    const exitFocusBtn = document.getElementById('exitFocusBtn');
    const exitFocusTopBtn = document.getElementById('exitFocusTopBtn');
    const exitFocusPanelBtn = document.getElementById('exitFocusPanelBtn');
    const completePanel = document.getElementById('completePanel');
    const completeText = document.getElementById('completeText');
    const showSaveFormBtn = document.getElementById('showSaveFormBtn');
    const saveSessionForm = document.getElementById('saveSessionForm');
    const topicInput = document.getElementById('topicInput');
    const minutesInput = document.getElementById('minutesInput');
    const challengeShell = document.getElementById('challengeShell');
    const focusDimLayer = document.getElementById('focusDimLayer');
    const focusObjectModal = document.getElementById('focusObjectModal');
    const focusPreview = document.getElementById('focusPreview');
    const focusOptions = Array.from(document.querySelectorAll('.focus-option'));
    const confirmFocusBtn = document.getElementById('confirmFocusBtn');
    const cancelFocusBtn = document.getElementById('cancelFocusBtn');

    if (!timerDisplay || !statusText || !statusDot || !setMinutesInput || !visualObject) {
        return;
    }

    const objectLabels = {
        candle: 'Candle',
        ice: 'Ice Cube',
        'hot-water': 'Hot Water'
    };

    let state = 'ready';
    let isModalOpen = false;
    let startPendingFromModal = false;
    let selectedObject = '';
    let pendingObject = '';
    let durationSeconds = 10 * 60;
    let remainingSeconds = durationSeconds;
    let startTimestamp = null;
    let rafId = null;
    let lastWholeSecond = null;

    function clampMinutes(value) {
        const parsed = parseInt(value || '10', 10);
        if (Number.isNaN(parsed)) {
            return 10;
        }
        return Math.max(1, Math.min(600, parsed));
    }

    function formatTime(seconds) {
        const safe = Math.max(0, Math.floor(seconds));
        const mins = String(Math.floor(safe / 60)).padStart(2, '0');
        const secs = String(safe % 60).padStart(2, '0');
        return `${mins}:${secs}`;
    }

    function progress() {
        if (durationSeconds <= 0) {
            return 0;
        }
        return Math.max(0, Math.min(1, remainingSeconds / durationSeconds));
    }

    function objectMarkup(type) {
        if (type === 'candle') {
            return `
                <div class="visual-shell" data-kind="candle">
                    <div class="candle-wrap">
                        <div class="candle-flame"></div>
                        <div class="candle-body">
                            <div class="candle-wax"></div>
                            <div class="candle-drip left"></div>
                            <div class="candle-drip right"></div>
                            <div class="candle-wick"></div>
                        </div>
                    </div>
                </div>
            `;
        }

        if (type === 'ice') {
            return `
                <div class="visual-shell" data-kind="ice">
                    <div class="ice-wrap"></div>
                </div>
            `;
        }

        if (type === 'hot-water') {
            return `
                <div class="visual-shell" data-kind="hot-water">
                    <div class="water-wrap">
                        <div class="water-cup">
                            <span class="steam s1"></span>
                            <span class="steam s2"></span>
                            <span class="steam s3"></span>
                            <span class="steam s4"></span>
                            <div class="water-fill">
                                <span class="water-wave"></span>
                            </div>
                        </div>
                        <div class="water-handle"></div>
                    </div>
                </div>
            `;
        }

        return '';
    }

    /* Visual improvement logic:
       smooth progress-driven transform for candle melt, ice shrink, and water level. */
    function applyObjectProgress(container, type, value) {
        const p = Math.max(0, Math.min(1, value));

        if (type === 'candle') {
            const wrap = container.querySelector('.candle-wrap');
            const wax = container.querySelector('.candle-wax');
            const flame = container.querySelector('.candle-flame');
            const body = container.querySelector('.candle-body');

            if (wrap) {
                wrap.style.transform = `scaleY(${(0.2 + (p * 0.8)).toFixed(4)})`;
            }

            if (wax) {
                wax.style.height = `${Math.max(8, p * 100).toFixed(2)}%`;
            }

            if (body) {
                body.style.setProperty('--melt-level', (1 - p).toFixed(4));
            }

            if (flame) {
                flame.style.opacity = p <= 0.03 ? '0' : '1';
                flame.style.transform = `translateX(-50%) scale(${(0.74 + (p * 0.26)).toFixed(4)})`;
            }
            return;
        }

        if (type === 'ice') {
            const ice = container.querySelector('.ice-wrap');
            if (ice) {
                const scale = 0.2 + (p * 0.8);
                ice.style.transform = `scale(${scale.toFixed(4)})`;
                ice.style.opacity = (0.14 + (p * 0.86)).toFixed(4);
                ice.style.filter = `saturate(${(0.84 + (p * 0.16)).toFixed(4)})`;
            }
            return;
        }

        if (type === 'hot-water') {
            const fill = container.querySelector('.water-fill');
            const steamList = container.querySelectorAll('.steam');
            if (fill) {
                fill.style.height = `${Math.max(5, p * 100).toFixed(2)}%`;
                fill.style.opacity = (0.26 + (p * 0.74)).toFixed(4);
            }
            steamList.forEach((steam) => {
                steam.style.opacity = p <= 0.03 ? '0' : (0.22 + (p * 0.78)).toFixed(4);
            });
        }
    }

    function mountObject(container, type, value) {
        container.innerHTML = objectMarkup(type);
        applyObjectProgress(container, type, value);
    }

    function setStatus(next) {
        const labels = {
            ready: 'Ready',
            running: 'Running...',
            paused: 'Paused',
            finished: 'Finished'
        };

        statusText.textContent = labels[next] || 'Ready';
        statusDot.className = `status-dot ${next}`;
    }

    function updateActionButtons() {
        startBtn.disabled = state === 'running';
        startBtn.textContent = state === 'paused' ? 'Resume' : 'Start';

        pauseBtn.disabled = state !== 'running';
        endBtn.disabled = !(state === 'running' || state === 'paused');
    }

    function render() {
        timerDisplay.textContent = formatTime(remainingSeconds);

        const nowWhole = Math.floor(remainingSeconds);
        if (nowWhole !== lastWholeSecond) {
            timerDisplay.classList.remove('pulse');
            void timerDisplay.offsetWidth;
            timerDisplay.classList.add('pulse');
            lastWholeSecond = nowWhole;
        }

        if (selectedObject) {
            applyObjectProgress(visualObject, selectedObject, progress());
        }
    }

    function enterFocusMode() {
        // Interaction fix:
        // focus layer is non-interactive, and content keeps higher z-index.
        challengeShell.classList.add('focus-active');
        document.body.classList.add('challenge-focus-mode');
        focusDimLayer.classList.remove('hidden');
        exitFocusBtn.classList.remove('hidden');
        exitFocusTopBtn.classList.remove('hidden');
    }

    function exitFocusMode() {
        challengeShell.classList.remove('focus-active');
        document.body.classList.remove('challenge-focus-mode');
        focusDimLayer.classList.add('hidden');
        exitFocusBtn.classList.add('hidden');
        exitFocusTopBtn.classList.add('hidden');
    }

    function finishSession(autoComplete) {
        if (autoComplete) {
            remainingSeconds = 0;
        }

        cancelAnimationFrame(rafId);
        rafId = null;

        state = 'finished';
        setStatus(state);
        updateActionButtons();

        const studiedSeconds = Math.max(1, Math.round(durationSeconds - remainingSeconds));
        const studiedMinutes = Math.max(1, Math.round(studiedSeconds / 60));

        completeText.textContent = `Durasi tercatat: ${studiedMinutes} menit.`;
        completePanel.classList.remove('hidden');
        saveSessionForm.classList.remove('hidden');
        minutesInput.value = studiedMinutes;

        if (!topicInput.value.trim()) {
            topicInput.value = `Focus Challenge ${studiedMinutes} menit`;
        }

        render();
    }

    /* Continuous timer loop for smooth visual transitions and second-based pulse. */
    function loop(now) {
        if (state !== 'running') {
            return;
        }

        const elapsed = (now - startTimestamp) / 1000;
        remainingSeconds = Math.max(0, durationSeconds - elapsed);
        render();

        if (remainingSeconds <= 0) {
            finishSession(true);
            return;
        }

        rafId = requestAnimationFrame(loop);
    }

    function startRunning() {
        const elapsedBeforeResume = durationSeconds - remainingSeconds;
        startTimestamp = performance.now() - (elapsedBeforeResume * 1000);

        state = 'running';
        setStatus(state);
        updateActionButtons();

        cancelAnimationFrame(rafId);
        rafId = requestAnimationFrame(loop);
    }

    function openObjectModal({ startAfterSelect = false } = {}) {
        // Failsafe: if modal node is unavailable for any reason,
        // do not block the timer flow.
        if (!focusObjectModal) {
            return false;
        }

        startPendingFromModal = startAfterSelect;
        pendingObject = selectedObject || '';

        focusOptions.forEach((option) => {
            option.classList.toggle('active', option.dataset.object === pendingObject);
        });

        if (pendingObject) {
            mountObject(focusPreview, pendingObject, 1);
            confirmFocusBtn.disabled = false;
        } else {
            focusPreview.innerHTML = '<p class="history-empty">Pilih visual untuk preview.</p>';
            confirmFocusBtn.disabled = true;
        }

        isModalOpen = true;
        focusObjectModal.classList.remove('hidden');
        focusObjectModal.classList.add('is-open');
        focusObjectModal.setAttribute('aria-hidden', 'false');
        return true;
    }

    function closeObjectModal() {
        if (!focusObjectModal) {
            isModalOpen = false;
            startPendingFromModal = false;
            return;
        }

        isModalOpen = false;
        startPendingFromModal = false;
        pendingObject = '';
        focusObjectModal.classList.remove('is-open');
        focusObjectModal.classList.add('hidden');
        focusObjectModal.setAttribute('aria-hidden', 'true');
    }

    function applyObject(type) {
        selectedObject = type;
        selectedObjectLabel.textContent = objectLabels[type] || '-';
        pickObjectBtn.textContent = `Visual: ${objectLabels[type] || 'Custom'}`;
        objectHelper.textContent = `${objectLabels[type] || 'Objek'} akan berubah mengikuti progress timer.`;
        mountObject(visualObject, type, progress());
    }

    function startOrResume() {
        if (state === 'paused') {
            enterFocusMode();
            startRunning();
            return;
        }

        // Required flow: Start opens modal, then confirm starts timer.
        const opened = openObjectModal({ startAfterSelect: true });
        if (!opened) {
            // Failsafe: UI stays usable and timer still starts.
            if (!selectedObject) {
                applyObject('candle');
            }

            if (state === 'ready' || state === 'finished') {
                durationSeconds = clampMinutes(setMinutesInput.value) * 60;
                remainingSeconds = durationSeconds;
                minutesInput.value = Math.max(1, Math.round(durationSeconds / 60));
                completePanel.classList.add('hidden');
                saveSessionForm.classList.add('hidden');
                lastWholeSecond = null;
            }

            enterFocusMode();
            startRunning();
        }
    }

    function startAfterModalConfirm() {
        if (state === 'ready' || state === 'finished') {
            durationSeconds = clampMinutes(setMinutesInput.value) * 60;
            remainingSeconds = durationSeconds;
            minutesInput.value = Math.max(1, Math.round(durationSeconds / 60));
            completePanel.classList.add('hidden');
            saveSessionForm.classList.add('hidden');
            lastWholeSecond = null;
        }

        enterFocusMode();
        startRunning();
    }

    function pauseTimer() {
        if (state !== 'running') {
            return;
        }

        cancelAnimationFrame(rafId);
        rafId = null;

        state = 'paused';
        setStatus(state);
        updateActionButtons();
    }

    function endTimerNow() {
        if (state !== 'running' && state !== 'paused') {
            return;
        }

        finishSession(false);
    }

    function resetTimer() {
        cancelAnimationFrame(rafId);
        rafId = null;

        durationSeconds = clampMinutes(setMinutesInput.value) * 60;
        remainingSeconds = durationSeconds;
        minutesInput.value = Math.max(1, Math.round(durationSeconds / 60));

        state = 'ready';
        setStatus(state);
        updateActionButtons();

        completePanel.classList.add('hidden');
        saveSessionForm.classList.add('hidden');
        lastWholeSecond = null;
        render();
    }

    setMinutesInput.addEventListener('change', () => {
        if (state === 'running') {
            return;
        }

        durationSeconds = clampMinutes(setMinutesInput.value) * 60;
        if (state === 'ready' || state === 'finished') {
            remainingSeconds = durationSeconds;
        }

        minutesInput.value = Math.max(1, Math.round(durationSeconds / 60));
        render();
    });

    startBtn.addEventListener('click', startOrResume);
    pauseBtn.addEventListener('click', pauseTimer);
    endBtn.addEventListener('click', endTimerNow);
    resetBtn.addEventListener('click', resetTimer);

    pickObjectBtn.addEventListener('click', () => {
        // Modal is intentionally opened from Start to prevent accidental blocking.
        objectHelper.textContent = 'Klik Start untuk memilih visual lalu memulai sesi.';
        pickObjectBtn.blur();
    });
    exitFocusBtn.addEventListener('click', exitFocusMode);
    exitFocusTopBtn.addEventListener('click', exitFocusMode);
    exitFocusPanelBtn.addEventListener('click', exitFocusMode);

    showSaveFormBtn.addEventListener('click', () => {
        saveSessionForm.classList.remove('hidden');
        saveSessionForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        topicInput.focus();
    });

    focusOptions.forEach((option) => {
        option.addEventListener('click', () => {
            pendingObject = option.dataset.object;
            focusOptions.forEach((button) => {
                button.classList.toggle('active', button === option);
            });
            mountObject(focusPreview, pendingObject, 1);
            confirmFocusBtn.disabled = false;
        });
    });

    confirmFocusBtn.addEventListener('click', () => {
        if (!pendingObject) {
            return;
        }

        const shouldStart = startPendingFromModal;
        applyObject(pendingObject);
        closeObjectModal();

        if (shouldStart) {
            startAfterModalConfirm();
        }
    });

    cancelFocusBtn.addEventListener('click', closeObjectModal);

    focusObjectModal.addEventListener('click', (event) => {
        if (event.target === focusObjectModal) {
            closeObjectModal();
        }
    });

    window.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        if (isModalOpen) {
            closeObjectModal();
            return;
        }

        if (document.body.classList.contains('challenge-focus-mode')) {
            exitFocusMode();
        }
    });

    render();
    setStatus(state);
    updateActionButtons();
})();
</script>
@endsection
