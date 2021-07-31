require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var count = 1;
//var urlfield = '<textarea name="url_' + count + '" class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"  placeholder="Enter your url"></textarea>';
var textareas = document.getElementById('textareas');
var addUrl = function(e) {
	e.preventDefault();
	console.log('button clicked');
	var urlfield = document.createElement('input');
	urlfield.type = 'text';
	urlfield.name = 'url_' + count;
	urlfield.className = 'bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white';
	urlfield.placeholder = 'Enter your url';
	textareas.appendChild(urlfield);
	count++;
};
document.getElementById('add_url').addEventListener('click', addUrl);
