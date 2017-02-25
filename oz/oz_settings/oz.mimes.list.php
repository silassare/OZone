<?php

	OZoneSettings::set( 'oz.mimes.list', array(
		//CUSTOM OZONE FILE MIME AND EXTENSION
		'ofa' => array( "text/x-ozone-file-alias", "Ozone File Alias" ),

		'mdf'     => array( "application/access", "Microsoft Access" ),
		'xls'     => array( "application/excel", "Microsoft Excel" ),
		'xls'     => array( "application/vnd.ms-excel", "Microsoft Excel" ),
		'pfr'     => array( "application/font-tdpfr", "TrueDoc Portable Font Resource" ),
		'spl'     => array( "application/futuresplash", "Macromedia Flash" ),
		'hep'     => array( "application/hep", "Hummingbird Host Explorer Profiles" ),
		'wks'     => array( "application/lotus-123", "Lotus 123" ),
		'hqx'     => array( "application/mac-binhex40", "Macintosh binhexed archives" ),
		'ppt'     => array( "application/mspowerpoint", "Microsoft Powerpoint" ),
		'doc'     => array( "application/msword", "Microsoft Word" ),
		'exe'     => array( "application/octet-stream", "Binary File" ),
		'bin'     => array( "application/octet-stream", "Binary File" ),
		'ani'     => array( "application/octet-stream", "Binary File" ),
		'oda'     => array( "application/oda" ),
		'pm5'     => array( "application/pagemaker", 'PageMaker' ),
		'pt5'     => array( "application/pagemaker", 'PageMaker' ),
		'pm'      => array( "application/pagemaker", 'PageMaker' ),
		'pdf'     => array( "application/pdf", "Adobe Acrobat" ),
		'ai'      => array( "application/postscript", "Postscript File" ),
		'eps'     => array( "application/postscript", "Postscript File" ),
		'ps'      => array( "application/postscript", "Postscript File" ),
		'rtf'     => array( "application/rtf", "Rich Text File" ),
		'tbk'     => array( "application/toolbook", 'Toolbook' ),
		'wp'      => array( "application/wordperfect", 'WordPerfect' ),
		'wp5'     => array( "application/wordperfect5.1", "WordPerfect Version 5.1" ),
		'wp6'     => array( "application/wordperfect6.1", "WordPerfect Version 6.1" ),
		'wpd'     => array( "application/wordperfectd", 'WordPerfect' ),
		'bcpio'   => array( "application/x-bcpio" ),
		'cpio'    => array( "application/x-cpio" ),
		'csh'     => array( "application/x-csh", "C-Shell Program" ),
		'dcr'     => array( "application/x-director", "Director File" ),
		'dvi'     => array( "application/x-dvi", "TeX dvi Format" ),
		'gtar'    => array( "application/x-gtar", "Gzip and Tar file" ),
		'gz'      => array( "application/x-gzip", "Gzip and Tar file" ),
		'tgz'     => array( "application/x-gzip", "Gzip and Tar file" ),
		'z'       => array( "application/x-compress", "Gzip and Tar file" ),
		'hdf'     => array( "application/x-hdf", "NCSA HDF" ),
		'ica'     => array( "application/x-ica", 'WinFrames' ),
		'js'      => array( "application/x-javascript", 'Javascript' ),
		'mif'     => array( "application/x-mif" ),
		'nc'      => array( "application/x-netcdf" ),
		'cdf'     => array( "application/x-netcdf" ),
		'sh'      => array( "application/x-sh", "sh Shell Program" ),
		'shar'    => array( "application/x-shar" ),
		'swf'     => array( "application/x-shockwave-flash", "Macromedia Shockwave file" ),
		'sav'     => array( "application/x-spss", 'SPSS' ),
		'spp'     => array( "application/x-spss", 'SPSS' ),
		'sbs'     => array( "application/x-spss", 'SPSS' ),
		'sps'     => array( "application/x-spss", 'SPSS' ),
		'spo'     => array( "application/x-spss", 'SPSS' ),
		'sit'     => array( "application/x-stuffit", "Macintosh Stuff-It" ),
		'sv4cpio' => array( "application/x-sv4cpio" ),
		'sv4crc'  => array( "application/x-sv4crc" ),
		'tar'     => array( "application/x-tar", "UNIX Tape Archive" ),
		'tcl'     => array( "application/x-tcl", "TCL Programming Language" ),
		'latex'   => array( "application/x-latex", "Latex File" ),
		'tex'     => array( "application/x-tex", "Tex/LaTeX" ),
		'texinfo' => array( "application/x-texinfo", 'TexInfo' ),
		'texi'    => array( "application/x-texinfo", 'TexInfo' ),
		't'       => array( "application/x-troff", "Troff file" ),
		'tr'      => array( "application/x-troff", "Troff file" ),
		'roff'    => array( "application/x-troff", "Troff file" ),
		'man'     => array( "application/x-troff-man", "Troff with MAN macros" ),
		'me'      => array( "application/x-troff-me", "Troff with ME macros" ),
		'ms'      => array( "application/x-troff-ms", "Troff with MS macros" ),
		'ustar'   => array( "application/x-ustar", "Ustar file" ),
		'mdb'     => array( "application/vnd.ms-access", "MS Access" ),
		'mda'     => array( "application/vnd.ms-access", "MS Access" ),
		'mpp'     => array( "application/vnd.ms-project", "MS Project" ),
		'src'     => array( "application/x-wais-source", "WAIS Sources" ),
		'zip'     => array( "application/zip", "ZIP Compressed File" ),
		'jar'     => array( "application/zip", "ZIP Compressed File" ),
		'au'      => array( "audio/basic", "Audio Sound File" ),
		'snd'     => array( "audio/basic", "Audio Sound File" ),
		'aif'     => array( "audio/x-aiff", "AIFF Sound File" ),
		'aiff'    => array( "audio/x-aiff", "AIFF Sound File" ),
		'aifc'    => array( "audio/x-aiff", "AIFF Sound File" ),
		'mid'     => array( "audio/x-midi", "MIDI Sound File" ),
		'ra'      => array( "audio/x-pn-realaudio", "REALAUDIO Sound File" ),
		'ram'     => array( "audio/x-pn-realaudio", "REALAUDIO Sound File" ),
		'rm'      => array( "audio/x-pn-realaudio", "REALAUDIO Sound File" ),
		'rpm'     => array( "audio/x-pn-realaudio", "REALAUDIO Sound File" ),
		'wav'     => array( "audio/x-wav", "WAV Sound File" ),
		'mp3'     => array( "audio/x-mpegurl", "MP3 Sound File" ),
		'mp3'     => array( "audio/mpeg3", "MP3 Sound File" ),
		'mp3'     => array( "audio/x-mpeg-3", "MP3 Sound File" ),
		'mp2'     => array( "audio/mpeg", "MP2 Sound File" ),
		'mpa'     => array( "audio/mpeg", "MP2 Sound File" ),
		'mpg'     => array( "audio/mpeg", "MP2 Sound File" ),
		'mpga'    => array( "audio/mpeg", "MP2 Sound File" ),
		'pdb'     => array( "chemical/x-pdb", "PDB Chemistry Model File" ),
		'xyz'     => array( "chemical/x-xyz", "XYZ Chemistry Model File" ),
		'dwf'     => array( "drawing/x-dwf", 'AutoCAD' ),
		'gif'     => array( "image/gif", "GIF image file" ),
		'ief'     => array( "image/ief", "Image Exchange" ),
		'jpeg'    => array( "image/jpeg", "JPG image file" ),
		'jpg'     => array( "image/jpeg", "JPG image file" ),
		'jpe'     => array( "image/jpeg", "JPG image file" ),
		'png'     => array( "image/png", "Portable Network Graphics" ),
		'tiff'    => array( "image/tiff", "TIFF image file" ),
		'tif'     => array( "image/tiff", "TIFF image file" ),
		'ras'     => array( "image/x-cmu-raster" ),
		'pnm'     => array( "image/x-portable-anymap" ),
		'pbm'     => array( "image/x-portable-bitmap" ),
		'pgm'     => array( "image/x-portable-graymap" ),
		'ppm'     => array( "image/x-portable-pixmap" ),
		'rgb'     => array( "image/x-rgb", "RGB Image File" ),
		'xbm'     => array( "image/x-xbitmap", "X-bitmap Image File" ),
		'xpm'     => array( "image/x-xpixmap", "X-pixmap Image File" ),
		'xwd'     => array( "image/x-xwindowdump" ),
		'css'     => array( "text/css", "Cascading Style Sheet" ),
		'html'    => array( "text/html", "HTML Document" ),
		'htm'     => array( "text/html", "HTML Document" ),
		'txt'     => array( "text/plain", "Plain Text File" ),
		'ini'     => array( "text/plain", "Plain Text File" ),
		'log'     => array( "text/plain", "Plain Text File" ),
		'in'      => array( "text/plain", "Plain Text File" ),
		'cfg'     => array( "text/plain", "Plain Text File" ),
		'm4'      => array( "text/plain", "Plain Text File" ),
		'sh'      => array( "text/plain", "Plain Text File" ),
		'rtx'     => array( "text/richtext", "Rich Text File" ),
		'tsv'     => array( "text/tab-separated-values" ),
		'etx'     => array( "text/x-setext" ),
		'sgml'    => array( "text/x-sgml", "SGML Document" ),
		'sgm'     => array( "text/x-sgml", "SGML Document" ),
		'mpeg'    => array( "video/mpeg", "MPEG Movie File" ),
		'mpg'     => array( "video/mpeg", "MPEG Movie File" ),
		'mpe'     => array( "video/mpeg", "MPEG Movie File" ),
		'qt'      => array( "video/quicktime", "Quicktime Movie File" ),
		'mov'     => array( "video/quicktime", "Quicktime Movie File" ),
		'asf'     => array( "video/x-ms-asf", "Windows Media File" ),
		'asx'     => array( "video/x-ms-asf", "Windows Media File" ),
		'avi'     => array( "video/x-msvideo", "AVI Movie File" ),
		'movie'   => array( "video/x-sgi-movie", "SGI Movie File" )
	) );