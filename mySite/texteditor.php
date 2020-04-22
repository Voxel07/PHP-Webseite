<?php
// include "Header.php";
echo'<link rel="stylesheet" href="../Styles/style_Texteditor.css">';
?>



<form methoder = "post" action="" enctype="multipart/form-data">

<div class="editor">
	<div class="editor-menuebar" >
		<!-- Linksbündig -->
		<div class="editor-button" data-attribute="justifyleft"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 0 20 20">
			<path  d="M1.683,3.39h16.676C18.713,3.39,19,3.103,19,2.749s-0.287-0.642-0.642-0.642H1.683c-0.354,0-0.641,0.287-0.641,0.642S1.328,3.39,1.683,3.39z M1.683,7.879h11.545c0.354,0,0.642-0.287,0.642-0.641s-0.287-0.642-0.642-0.642H1.683c-0.354,0-0.641,0.287-0.641,0.642S1.328,7.879,1.683,7.879z M18.358,11.087H1.683c-0.354,0-0.641,0.286-0.641,0.641s0.287,0.642,0.641,0.642h16.676c0.354,0,0.642-0.287,0.642-0.642S18.713,11.087,18.358,11.087zM11.304,15.576H1.683c-0.354,0-0.641,0.287-0.641,0.642s0.287,0.641,0.641,0.641h9.621c0.354,0,0.642-0.286,0.642-0.641S11.657,15.576,11.304,15.576z"></path>
			</svg>
		</div>
		<!-- Zentrieren -->
		<div class="editor-button" data-attribute="justifycenter"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 0 20 20">
			<path  d="M1.686,3.327h16.754c0.356,0,0.645-0.288,0.645-0.644c0-0.356-0.288-0.645-0.645-0.645H1.686c-0.356,0-0.644,0.288-0.644,0.645C1.042,3.039,1.33,3.327,1.686,3.327z M4.263,6.549c-0.356,0-0.644,0.288-0.644,0.645c0,0.356,0.288,0.644,0.644,0.644h11.599c0.356,0,0.645-0.288,0.645-0.644c0-0.356-0.288-0.645-0.645-0.645H4.263z M18.439,11.06H1.686c-0.356,0-0.644,0.288-0.644,0.644c0,0.356,0.288,0.645,0.644,0.645h16.754c0.356,0,0.645-0.288,0.645-0.645C19.084,11.348,18.796,11.06,18.439,11.06z M15.218,15.57H5.552c-0.356,0-0.645,0.288-0.645,0.645c0,0.355,0.289,0.644,0.645,0.644h9.666c0.355,0,0.645-0.288,0.645-0.644C15.862,15.858,15.573,15.57,15.218,15.57z"></path>
			</svg>
		</div>
		<!-- Rechtsbündig -->
		<div class="editor-button" data-attribute="justifyright"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 0 20 20">
			<path  d="M1.321,3.417h17.024C18.707,3.417,19,3.124,19,2.762c0-0.362-0.293-0.655-0.654-0.655H1.321c-0.362,0-0.655,0.293-0.655,0.655C0.667,3.124,0.959,3.417,1.321,3.417z M18.346,15.857H8.523c-0.361,0-0.655,0.293-0.655,0.654c0,0.362,0.293,0.655,0.655,0.655h9.822c0.361,0,0.654-0.293,0.654-0.655C19,16.15,18.707,15.857,18.346,15.857z M18.346,11.274H1.321c-0.362,0-0.655,0.292-0.655,0.654s0.292,0.654,0.655,0.654h17.024c0.361,0,0.654-0.292,0.654-0.654S18.707,11.274,18.346,11.274z M18.346,6.69H6.56c-0.362,0-0.655,0.293-0.655,0.655C5.904,7.708,6.198,8,6.56,8h11.786C18.707,8,19,7.708,19,7.345C19,6.983,18.707,6.69,18.346,6.69z"></path>
			</svg>
		</div>
		<!-- Textgröße -->
		<div class="editor-button" data-attribute="fontSize"  onmousedown="event.preventDefault();" onclick="option_toggle('groeße')">
			<svg class="svg-icon" viewBox="0 0 512 512">
			<g>
			<path style="fill:#ffffff;" d="M309.333,106.666c-5.891,0-10.667-4.776-10.667-10.667v-32H21.333v32c0,5.891-4.776,10.667-10.667,10.667S0,101.89,0,95.999V53.332c0-5.891,4.776-10.667,10.667-10.667h298.667c5.891,0,10.667,4.776,10.667,10.667v42.667C320,101.89,315.224,106.666,309.333,106.666z"/>
			<path style="fill:#ffffff;" d="M160,426.666c-5.891,0-10.667-4.776-10.667-10.667V53.332c0-5.891,4.776-10.667,10.667-10.667c5.891,0,10.667,4.776,10.667,10.667v362.667C170.667,421.89,165.891,426.666,160,426.666z"/>
			<path style="fill:##ffffff;" d="M202.667,426.666h-85.333c-5.891,0-10.667-4.776-10.667-10.667s4.776-10.667,10.667-10.667h85.333c5.891,0,10.667,4.776,10.667,10.667S208.558,426.666,202.667,426.666z"/>
			</g>
			<g>
			<path style="fill:#f27a18;" d="M458.667,106.666c-2.831,0.005-5.548-1.115-7.552-3.115L416,68.415l-35.115,35.136c-4.237,4.093-10.99,3.975-15.083-0.262c-3.993-4.134-3.993-10.687,0-14.821l42.667-42.667c4.165-4.164,10.917-4.164,15.083,0l42.667,42.667c4.159,4.172,4.148,10.926-0.024,15.085C464.196,105.546,461.489,106.665,458.667,106.666z"/>
			<path style="fill:#f27a18;" d="M416,426.666c-2.831,0.005-5.548-1.115-7.552-3.115l-42.667-42.667c-4.093-4.237-3.976-10.99,0.261-15.083c4.134-3.993,10.688-3.993,14.821,0L416,400.916l35.115-35.115c4.237-4.093,10.99-3.976,15.083,0.261c3.993,4.134,3.993,10.688,0,14.821l-42.667,42.667C421.532,425.545,418.824,426.665,416,426.666z"/>
			<path style="fill:#f27a18;" d="M416,426.666c-5.891,0-10.667-4.776-10.667-10.667V53.332c0-5.891,4.776-10.667,10.667-10.667c5.891,0,10.667,4.776,10.667,10.667v362.667C426.667,421.89,421.891,426.666,416,426.666z"/>
			</svg>
		</div>	
		<!-- Schriftfarbe ändern -->
		<div class="editor-button" data-attribute="foreColor"  onmousedown="event.preventDefault();" onclick="option_toggle('farbe')">
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<path d="m169.96875 329.027344-45.441406-45.441406c-2.003906-1.984376-4.695313-3.113282-7.53125-3.113282-2.835938 0-5.566406 1.128906-7.550782 3.136719l-92.546874 92.800781c-3.050782 3.050782-3.945313 7.636719-2.28125 11.625 1.621093 3.96875 5.527343 6.570313 9.835937 6.570313h90.625c2.835937 0 5.542969-1.128907 7.550781-3.113281l47.359375-47.359376c4.136719-4.183593 4.136719-10.925781-.019531-15.105468zm0 0" fill="#f27a18"/>
			<path d="m405.636719 458.605469h-384c-11.796875 0-21.332031-9.558594-21.332031-21.332031 0-11.777344 9.535156-21.335938 21.332031-21.335938h384c11.796875 0 21.332031 9.558594 21.332031 21.335938 0 11.773437-9.535156 21.332031-21.332031 21.332031zm0 0" fill="#f27a18"/>
			<path d="m245.957031 328.324219-120.683593-120.683594c-3.625-3.625-8.789063-5.289063-13.867188-4.480469-5.078125.832032-9.449219 4.03125-11.753906 8.640625l-30.164063 60.351563c-3.09375 6.164062-1.878906 13.609375 3.007813 18.476562l90.515625 90.515625c3.074219 3.070313 7.167969 4.691407 11.308593 4.691407 2.429688 0 4.882813-.554688 7.144532-1.683594l60.332031-30.164063c4.605469-2.304687 7.828125-6.679687 8.640625-11.753906.832031-5.121094-.832031-10.285156-4.480469-13.910156zm0 0" fill="#eceff1"/>
			<path d="m436.441406 66.265625-49.152344-49.132813c-21.78125-21.78125-56.960937-22.933593-80.128906-2.664062l-211.304687 184.894531c-3.328125 2.921875-5.292969 7.082031-5.460938 11.519531-.148437 4.4375 1.554688 8.726563 4.691407 11.839844l135.765624 135.765625c3.007813 3.007813 7.082032 4.695313 11.308594 4.695313h.53125c4.417969-.152344 8.578125-2.136719 11.5-5.464844l184.894532-211.328125c20.308593-23.1875 19.136718-58.386719-2.644532-80.125zm0 0" fill="#607d8b"/></svg>
		</div>
		<!-- Unterstreichen -->
		<div class="editor-button" data-attribute="underline"  onmousedown="event.preventDefault();">
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<path style="fill:#f27a18;" d="M426.667,512H85.333c-5.891,0-10.667-4.776-10.667-10.667s4.776-10.667,10.667-10.667h341.333c5.891,0,10.667,4.776,10.667,10.667S432.558,512,426.667,512z"/>
			<path style="fill:#ffffff;" d="M170.667,21.333H85.333c-5.891,0-10.667-4.776-10.667-10.667S79.442,0,85.333,0h85.333c5.891,0,10.667,4.776,10.667,10.667S176.558,21.333,170.667,21.333z"/>
			<path style="fill:#ffffff;" d="M256,469.333c-76.544-0.094-138.573-62.122-138.667-138.667v-320C117.333,4.776,122.109,0,128,0	c5.891,0,10.667,4.776,10.667,10.667v320C138.667,395.468,191.199,448,256,448s117.333-52.532,117.333-117.333v-320C373.333,4.776,378.109,0,384,0c5.891,0,10.667,4.776,10.667,10.667v320C394.573,407.211,332.544,469.239,256,469.333z"/>
			<path style="fill:#ffffff;" d="M426.667,21.333h-85.333c-5.891,0-10.667-4.776-10.667-10.667S335.442,0,341.333,0h85.333c5.891,0,10.667,4.776,10.667,10.667S432.558,21.333,426.667,21.333z"/></svg>
		</div>
		<!-- Fett -->
		<div class="editor-button" data-attribute="bold"  onmousedown="event.preventDefault();">
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<path style="fill:#ffffff;" d="M288,512H106.667C100.776,512,96,507.224,96,501.333s4.776-10.667,10.667-10.667H288c58.881-0.071,106.596-47.786,106.667-106.667v-21.333C394.596,303.786,346.881,256.071,288,256H149.333c-5.891,0-10.667-4.776-10.667-10.667c0-5.891,4.776-10.667,10.667-10.667h96C304.244,234.667,352,186.91,352,128S304.244,21.333,245.333,21.333H106.667C100.776,21.333,96,16.558,96,10.667S100.776,0,106.667,0h138.667c70.692,0.037,127.97,57.374,127.933,128.067c-0.023,44.412-23.066,85.638-60.883,108.925c60.13,11.754,103.541,64.407,103.616,125.675V384C415.918,454.658,358.658,511.918,288,512z"/>
			<path style="fill:#ffffff;" d="M149.333,512c-5.891,0-10.667-4.776-10.667-10.667V10.667C138.667,4.776,143.442,0,149.333,0C155.224,0,160,4.776,160,10.667v490.667C160,507.224,155.224,512,149.333,512z"/>
			</svg>
		</div>
		<!-- Kursiv -->
		<div class="editor-button" data-attribute="italic"  onmousedown="event.preventDefault();">
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<path style="fill:#ffffff;" d="M213.333,512H128c-5.891,0-10.667-4.776-10.667-10.667s4.776-10.667,10.667-10.667h85.333c5.891,0,10.667,4.776,10.667,10.667S219.224,512,213.333,512z"/>
			<path style="fill:#ffffff;" d="M170.667,512c-1.192,0.001-2.375-0.201-3.499-0.597c-5.558-1.935-8.499-8.007-6.571-13.568L331.264,7.168c2.131-5.492,8.311-8.216,13.803-6.085c5.216,2.024,7.982,7.735,6.335,13.082L180.736,504.832C179.247,509.121,175.207,511.997,170.667,512z"/>
			<path style="fill:#ffffff;" d="M384,21.333h-85.333c-5.891,0-10.667-4.776-10.667-10.667S292.776,0,298.667,0H384c5.891,0,10.667,4.776,10.667,10.667S389.891,21.333,384,21.333z"/></svg>
		</div>
		<!-- Liste1 -->
		<div class="editor-button" data-attribute="insertUnorderedList"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 -43 512 512">
			<path  d="m85.332031 42.667969c0 23.5625-19.101562 42.664062-42.664062 42.664062-23.566407 0-42.667969-19.101562-42.667969-42.664062 0-23.566407 19.101562-42.667969 42.667969-42.667969 23.5625 0 42.664062 19.101562 42.664062 42.667969zm0 0"/>
			<path d="m85.332031 213.332031c0 23.566407-19.101562 42.667969-42.664062 42.667969-23.566407 0-42.667969-19.101562-42.667969-42.667969 0-23.5625 19.101562-42.664062 42.667969-42.664062 23.5625 0 42.664062 19.101562 42.664062 42.664062zm0 0"/>
			<path d="m85.332031 384c0 23.5625-19.101562 42.667969-42.664062 42.667969-23.566407 0-42.667969-19.105469-42.667969-42.667969s19.101562-42.667969 42.667969-42.667969c23.5625 0 42.664062 19.105469 42.664062 42.667969zm0 0"/>
			<path d="m490.667969 64h-320c-11.796875 0-21.335938-9.558594-21.335938-21.332031 0-11.777344 9.539063-21.335938 21.335938-21.335938h320c11.796875 0 21.332031 9.558594 21.332031 21.335938 0 11.773437-9.535156 21.332031-21.332031 21.332031zm0 0" fill="#f27a18"/>
			<path d="m490.667969 234.667969h-320c-11.796875 0-21.335938-9.558594-21.335938-21.335938 0-11.773437 9.539063-21.332031 21.335938-21.332031h320c11.796875 0 21.332031 9.558594 21.332031 21.332031 0 11.777344-9.535156 21.335938-21.332031 21.335938zm0 0" fill="#f27a18"/>
			<path d="m490.667969 405.332031h-320c-11.796875 0-21.335938-9.554687-21.335938-21.332031s9.539063-21.332031 21.335938-21.332031h320c11.796875 0 21.332031 9.554687 21.332031 21.332031s-9.535156 21.332031-21.332031 21.332031zm0 0" fill="#f27a18"></path>
			</svg>
		</div>
		<!-- Liste 2 -->
		<div class="editor-button" data-attribute="insertOrderedList"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 -43 512 512">
			<path  d="m69.332031 299h-53.332031c-8.832031 0-16-7.167969-16-16v-26.667969c0-20.585937 16.746094-37.332031 37.332031-37.332031h10.667969c2.945312 0 5.332031-2.390625 5.332031-5.332031v-5.335938c0-2.941406-2.386719-5.332031-5.332031-5.332031h-32c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h32c20.585938 0 37.332031 16.746094 37.332031 37.332031v5.335938c0 20.585937-16.746093 37.332031-37.332031 37.332031h-10.667969c-2.941406 0-5.332031 2.390625-5.332031 5.332031v10.667969h37.332031c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/>
			<path d="m48 421.667969h-21.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h21.332031c2.945312 0 5.332031-2.390625 5.332031-5.335938v-5.332031c0-2.945312-2.386719-5.332031-5.332031-5.332031h-32c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h32c20.585938 0 37.332031 16.746093 37.332031 37.332031v5.332031c0 20.589844-16.746093 37.335938-37.332031 37.335938zm0 0"/>
			<path d="m48 469.667969h-32c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h32c2.945312 0 5.332031-2.390625 5.332031-5.335938v-5.332031c0-2.945312-2.386719-5.332031-5.332031-5.332031h-21.332031c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h21.332031c20.585938 0 37.332031 16.746093 37.332031 37.332031v5.332031c0 20.589844-16.746093 37.335938-37.332031 37.335938zm0 0"/>
			<path d="m48 128.332031c-8.832031 0-16-7.167969-16-16v-80h-16c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h32c8.832031 0 16 7.167969 16 16v96c0 8.832031-7.167969 16-16 16zm0 0"/>
			<path d="m469.332031 85.667969h-320c-11.773437 0-21.332031-9.558594-21.332031-21.335938 0-11.773437 9.558594-21.332031 21.332031-21.332031h320c11.777344 0 21.335938 9.558594 21.335938 21.332031 0 11.777344-9.558594 21.335938-21.335938 21.335938zm0 0" fill="#f27a18"/>
			<path d="m469.332031 256.332031h-320c-11.773437 0-21.332031-9.554687-21.332031-21.332031s9.558594-21.332031 21.332031-21.332031h320c11.777344 0 21.335938 9.554687 21.335938 21.332031s-9.558594 21.332031-21.335938 21.332031zm0 0" fill="#f27a18"/>
			<path d="m469.332031 427h-320c-11.773437 0-21.332031-9.558594-21.332031-21.332031 0-11.777344 9.558594-21.335938 21.332031-21.335938h320c11.777344 0 21.335938 9.558594 21.335938 21.335938 0 11.773437-9.558594 21.332031-21.335938 21.332031zm0 0" fill="#f27a18"></path>
			</svg>
		</div>
		<!-- Link einbetten -->
		<div class="editor-button" data-attribute="createlink"  onmousedown="event.preventDefault();">
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<path style="fill:=#f27a18;" d="m354.496094 312.769531c-5.460938 0-10.921875-2.09375-15.082032-6.253906-8.34375-8.339844-8.34375-21.824219 0-30.164063l56.851563-56.851562c19.628906-19.457031 30.402344-45.421875 30.402344-73.21875 0-57.128906-46.488281-103.613281-103.617188-103.613281-27.796875 0-53.78125 10.773437-73.152343 30.335937l-56.917969 56.917969c-8.339844 8.339844-21.824219 8.339844-30.164063 0-8.339844-8.34375-8.339844-21.824219 0-30.167969l56.851563-56.851562c27.371093-27.648438 64.109375-42.902344 103.382812-42.902344 80.660157 0 146.28125 65.621094 146.28125 146.28125 0 39.277344-15.253906 76.011719-42.984375 103.46875l-56.789062 56.789062c-4.160156 4.136719-9.601563 6.230469-15.0625 6.230469zm0 0"/>
			<path style="fill:=#f27a18;" d="m146.28125 469.332031c-80.660156 0-146.28125-65.621093-146.28125-146.28125 0-39.273437 15.253906-76.011719 42.988281-103.464843l56.789063-56.792969c8.339844-8.339844 21.824218-8.339844 30.164062 0 8.339844 8.34375 8.339844 21.824219 0 30.167969l-56.851562 56.851562c-19.648438 19.476562-30.421875 45.441406-30.421875 73.238281 0 57.128907 46.484375 103.617188 103.613281 103.617188 27.796875 0 53.78125-10.773438 73.152344-30.335938l56.917968-56.917969c8.339844-8.34375 21.824219-8.34375 30.164063 0 8.34375 8.339844 8.34375 21.824219 0 30.164063l-56.851563 56.855469c-27.371093 27.644531-64.105468 42.898437-103.382812 42.898437zm0 0"/>
			<path style="fill:=#f27a18;" d="m149.332031 341.332031c-5.460937 0-10.921875-2.089843-15.082031-6.25-8.339844-8.339843-8.339844-21.824219 0-30.164062l170.667969-170.667969c8.339843-8.339844 21.824219-8.339844 30.164062 0 8.34375 8.34375 8.34375 21.824219 0 30.164062l-170.667969 170.667969c-4.15625 4.160157-9.621093 6.25-15.082031 6.25zm0 0"/>
			</svg>
		</div>
		<!-- Bild einfügen -->
		<!-- <div class="editor-button" data-attribute="insertImage"  onmousedown="event.preventDefault();">
			<svg class="svg-icon" viewBox="0 0 20 20">
			<path  d="M6.523,7.683c0.96,0,1.738-0.778,1.738-1.738c0-0.96-0.778-1.738-1.738-1.738c-0.96,0-1.738,0.778-1.738,1.738C4.785,6.904,5.563,7.683,6.523,7.683z M5.944,5.365h1.159v1.159H5.944V5.365z M18.113,0.729H1.888c-0.64,0-1.159,0.519-1.159,1.159v16.224c0,0.64,0.519,1.159,1.159,1.159h16.225c0.639,0,1.158-0.52,1.158-1.159V1.889C19.271,1.249,18.752,0.729,18.113,0.729z M18.113,17.532c0,0.321-0.262,0.58-0.58,0.58H2.467c-0.32,0-0.579-0.259-0.579-0.58V2.468c0-0.32,0.259-0.579,0.579-0.579h15.066c0.318,0,0.58,0.259,0.58,0.579V17.532z M15.91,7.85l-4.842,5.385l-3.502-2.488c-0.127-0.127-0.296-0.18-0.463-0.17c-0.167-0.009-0.336,0.043-0.463,0.17l-3.425,4.584c-0.237,0.236-0.237,0.619,0,0.856c0.236,0.236,0.62,0.236,0.856,0l3.152-4.22l3.491,2.481c0.123,0.123,0.284,0.179,0.446,0.174c0.16,0.005,0.32-0.051,0.443-0.174l5.162-5.743c0.238-0.236,0.238-0.619,0-0.856C16.529,7.614,16.146,7.614,15.91,7.85z"></path>
			</svg>
		</div> -->
		<!-- Bild skalieren -->
		<!-- <div class="editor-button" data-attribute="enableObjectResizing"  onmousedown="event.preventDefault();" >
			<svg class="svg-icon"  viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<g fill="#ffffff"><path d="m384 512c-11.796875 0-21.332031-9.558594-21.332031-21.332031v-320c0-11.757813-9.558594-21.335938-21.335938-21.335938h-320c-11.796875 0-21.332031-9.554687-21.332031-21.332031s9.535156-21.332031 21.332031-21.332031h320c35.285157 0 64 28.714843 64 64v320c0 11.773437-9.535156 21.332031-21.332031 21.332031zm0 0"/>
			<path d="m490.667969 405.332031h-320c-35.285157 0-64-28.714843-64-64v-320c0-11.773437 9.535156-21.332031 21.332031-21.332031s21.332031 9.558594 21.332031 21.332031v320c0 11.757813 9.558594 21.335938 21.335938 21.335938h320c11.796875 0 21.332031 9.554687 21.332031 21.332031s-9.535156 21.332031-21.332031 21.332031zm0 0"/></g></svg>
		</div> -->

		
	</div>
	<div class="editor-options">
		<div id ="farbe" class="versteckt">
			<div class = "farbe-auswahl">
				<div class="option" data-attribute="foreColor" data-dataset="red" style ="background-color: red " onmousedown="event.preventDefault();"></div>
				<div class="option" data-attribute="foreColor" data-dataset="green" style ="background-color: green " onmousedown="event.preventDefault();"> </div>
				<div class="option" data-attribute="foreColor" data-dataset="blue" style ="background-color: blue " onmousedown="event.preventDefault();"></div>
				<div class="option" data-attribute="foreColor" data-dataset="black" style ="background-color: black " onmousedown="event.preventDefault();"></div>
				<div class="option" data-attribute="foreColor" data-dataset="white" style ="background-color: white " onmousedown="event.preventDefault();"></div>
				<div class="option" data-attribute="foreColor" data-dataset="orange" style ="background-color: orange " onmousedown="event.preventDefault();"></div>
			</div>
		</div>
		<div id="groeße" class="versteckt">
		<div class = "groeße-auswahl">
			<!-- <div  style ="font-size: 10px ">1</div> -->
			<div class="option" data-attribute="fontSize" data-dataset=2 style ="font-size: 15px "onmousedown="event.preventDefault();">2</div>
			<div class="option" data-attribute="fontSize" data-dataset=3 style ="font-size: 20px "onmousedown="event.preventDefault();">3</div>
			<div class="option" data-attribute="fontSize" data-dataset=4 style ="font-size: 25px "onmousedown="event.preventDefault();">4</div>
			<div class="option" data-attribute="fontSize" data-dataset=5 style ="font-size: 30px "onmousedown="event.preventDefault();">5</div>
			<div class="option" data-attribute="fontSize" data-dataset=6 style ="font-size: 40px "onmousedown="event.preventDefault();">6</div>
			<div class="option" data-attribute="fontSize" data-dataset=7 style ="font-size: 50px "onmousedown="event.preventDefault();">7</div>
			<!-- <div  style ="font-size: 80px ">8</div> -->
			<!-- <div  style ="font-size: 90px ">9</div> -->
			<!-- <div  style ="font-size: 100px ">10</div> -->
		</div>
			
		</div>
	</div>

	<?php
		include_once "includes/dbh_Forum.inc.php";
		$sql ="SELECT * FROM posts WHERE id = 98";		
		$stmt = mysqli_stmt_init($conn2);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			echo "SQL Fehler !!";
		}
		else
		{
			mysqli_stmt_execute($stmt);
			$erg = mysqli_stmt_get_result($stmt);
			$inhalt = mysqli_fetch_assoc($erg);
			$ausgabe = $inhalt['inhalt'];
		}
	?>

<div id="list" class="output" contenteditable="true" onblur=textSpeichern()>
	
	
	
	<?php
	//Hier den Text entschärfen 
		echo $ausgabe;
	?>
	</div>
</div>
<!-- 
<input type="file" id="dateien" name="files[]" multiple ></input>

<button type="submit" name="upload-Post" >Senden</button> -->

</form>

<script>
	//Bissher super unsicher !!!!
	function textSpeichern(posta) {
		
		var xr = new XMLHttpRequest();
		var url = "saveText.php";
		var text = document.getElementById("list").innerHTML;
		var vars = "newText=" +text;	
		xr.open("POST", url ,true)
		xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
		xr.send(vars);



		//Bilder auch übertragen
		//gehot noch nicht

		// document.getElementById('file-input-element').onchange = function(){
		// if(this.files.length < 1) return false;
		// for(var i = 0; i < this.files.length; i++) console.log(this.files[i]);
		// };

		// var xhr = new XMLHttpRequest();
		// xhr.upload.addEventListener('progress',function(ev){
		// 	console.log((ev.loaded/ev.total)+'%');
		// }, false);
		// xhr.onreadystatechange = function(ev){
		// 	// Blah blah blah, you know how to make AJAX requests
		// };
		// xhr.open('POST', url, true);
		// var files = document.getElementById('file-input-element').files;
		// var data = new FormData();
		// for(var i = 0; i < files.length; i++) data.append('file'+i, files[i]);
		// xhr.send(data);
		
	}

</script>


<script src="../Skripte/Texteditor.js"></script>