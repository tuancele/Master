<?php
/*
Template Name: Corona
*/
?>
<div data-iframe-height="" class="container container-embed">
    <div class="dantri-corona vietnam-container">
      <span class="title">
      <span class="live">
        <span class="live-outer-dot">
          <span class="live-inner-dot"></span>
        </span>
        </span>
        Corona virus
        <span class="slide">
        <strong class="global">Thế giới</strong>
        <strong class="vietnam">Việt Nam</strong>
      </span>
        </span>
        <span>
      <span class="line">Số ca nhiễm:</span>
        <span class="line slide">
        <strong class="global" style="color: #cf1322">125.544</strong>
        <strong class="vietnam" style="color: #cf1322"><?php the_field('scn')?></strong>
        </span>
        </span>
        <span><span class="line">Tử vong:</span>
        <span class="line slide"><strong class="global" style="color: #000">4.601</strong>
      <strong class="vietnam" style="color: #000"><?php the_field('tv')?></strong>
    </span>
        </span>
        <span>
    <span class="line">Bình phục:</span>
        <span class="line slide">
      <strong class="global" style="color: #2b880f">66.335</strong>
      <strong class="vietnam" style="color: #2b880f"><?php the_field('bp')?></strong>
    </span>
        </span>
    </div>
</div>

<style>
*, :after, :before {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;}
    body, html {
    height: auto;}
    .container, body {
    background-color: #fff;}
    body {
    margin: 0;
    color: rgba(0,0,0,.65);
    font-size: 14px;
    font-family: Roboto,sans-serif;
    font-variant: tabular-nums;
    line-height: 1.5;
    background-color: #fff;
    -webkit-font-feature-settings: "tnum","tnum";
    font-feature-settings: "tnum","tnum";}
  .container{max-width: 100%;    margin: 0 auto;background: #fff;font-size: 14px;}
  .dantri-corona {
    border: 1px solid #1a7900;
    border-radius: 12px;
    overflow: hidden;
    background-color: rgba(26,121,0,.15);
    min-width: 600px;}
    .dantri-corona>span {
    padding: 6px 8px;
    font-size: 12px;
    line-height: 16px;
    color: #333;
    height: 28px;
    overflow: hidden;
    float: left;}
    .live {
    display: inline-block;
    position: relative;
    font-size: 0;
    line-height: 0;
    top: 2px;
    margin-right: 4px;}
    .dantri-corona>span {
    padding: 6px 8px;
    font-size: 12px;
    line-height: 16px;
    color: #333;
    height: 28px;
    overflow: hidden;
    float: left;}
    .live .live-inner-dot, .live .live-outer-dot {
    display: block;
    text-align: center;
    opacity: 1;
    background-color: rgba(207,19,34,.4);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    -webkit-animation: live-pulse 1.5s linear infinite;
    animation: live-pulse 1.5s linear infinite;}
    .live .live-inner-dot, .live .live-inner-dot:after {
    background-position: absolute;
    -moz-animation: live-pulse 1.5s linear infinite;
    -o-animation: live-pulse 1.5s linear infinite;}
    .live .live-inner-dot:after {
    content: "";
    display: block;
    text-align: center;
    opacity: 1;
    background-color: rgba(207,19,34,.4);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    -webkit-animation: live-pulse 1.5s linear infinite;
    animation: live-pulse 1.5s linear infinite;}
    .live:after {
    content: "";
    background-color: #cf1322;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    position: absolute;
    display: block;
    top: 1px;
    left: 1px;}
    .slide {
    position: relative;
    width: 48px;
    height: 16px;
    display: inline-block;
    vertical-align: bottom;
    overflow: hidden;}
    .dantri-corona>span.title .slide {
    width: 60px;}
    .global, .vietnam {
    position: absolute;
    -webkit-transition: all .2s linear;
    transition: all .2s linear;
    white-space: nowrap;
    font-weight: 500;
    left: 0;
    width: 100%;
    padding-left: 2px;}
    .global-container .global, .vietnam-container .vietnam {
    top: 0;}
    .vietnam-container .global {
    top: -24px;}
    .global-container .vietnam {
    top: 24px}
    .dantri-corona>span {
    padding: 6px 8px;
    font-size: 12px;
    line-height: 16px;
    color: #333;
    height: 28px;
    overflow: hidden;
    float: left;}
    .dantri-corona>span.title {
    color: #fff;
    background-color: #1a7900;
    border-top-right-radius: 24px;
    padding: 6px 18px 6px 12px;
    position: relative;
    text-transform: uppercase;}
</style>