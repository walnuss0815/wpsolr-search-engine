=== WPSOLR Search Engine ===

Contributors: WPSOLR.COM

Current Version: 5.4

Author:  WPSOLR.COM

Author URI: http://wpsolr.com/ 

Tags: Solr in WordPress, relevance, Solr search, fast search, wpsolr, apache solr, better search, site search, category search, search bar, comment search, faceting, relevant search, custom search, facets, page search, autocomplete, post search, online search, search, spell checking, search integration, did you mean, typeahead, search replacement, suggestions, search results, search by category, multi language, seo, lucene, solr, suggest, apache lucene

Requires at least: 3.7.1

Tested up to: 4.3

Stable tag: 5.4

Search is the secret weapon of the biggest websites. WPSOLR brings you the same technology, but for free.

== Description ==

= About us =
WPSOLR is backed by professionals. We are committed to develop and support new features for a long time.

= Need support ? =
- We deliver free bug and suggestions support with the community forum.
- We deliver professional Zendesk support, and an assistance to setup WPSOLR, with a <a href="http://www.gotosolr.com/en" target="_blank">Gotosolr subscription</a>.

= Great websites with nice search design, facets, suggestions, and did you mean features =
- Search "education" at http://www.nmc.org/
- Search "energy" at http://www.sunverge.com/
- Search "android" at https://digitalltag.de/
- Search "certification" at http://www.certwin.com/
- Contact us in the forum should your website be seen here!

= How fast is WPSOLR ? =
Searches should be under 500ms, whatever the number of posts you have.

= Is there any size limit ? =
WPSOLR can manage virtually any number of posts. The only constraint is the time to index all your posts the first time. We have users with hundreds of thousands, even millions, of posts.

= 1 million documents search =
Review on a 1 million documents search : <a href="https://wordpress.org/support/topic/awesome-plugin-1526" target="_blank">"Have used it to index over 1 million data in a custom WP application and the results have been fantastic"</a>.

= Our plugin website =
<a href="http://www.wpsolr.com" target="_blank">http://www.wpsolr.com</a>

= Our Solr hosting website =
If you do not want to host your own Solr server: <a href="http://www.gotosolr.com/en" target="_blank">http://www.gotosolr.com</a>

= Multi-language live search demo with WPML =
Visit <a href='http://www.gotosolr.com/en/search-wpsolr/?search=solr'>English/French WPML search page demo</a>.

= Super fast live suggestions 500ms =
Try on words like « solr », « cassandra », « security », « indexes », « search ».

= Super fast facets filters 500ms =
Notice the facets on the left side with their nice clicked Ajax display, the terms highlighting in the results snippets, the « order by » drop-down list.

= Did you mean =
To test the « did you mean » (suggestions on misspelled words), you can search on « soler » (suggested as « solr »), or « casandra » (suggested as « cassandra »).

= Compatibility =
Compatible with Apache Solr up to Solr 5.2

= Tuning =
Tune your search page and results with WPSOLR admin panels.

Tune even more your search with hundreds of parameters, just by tweaking the standard Apache Solr files, solrconfig.xml and schema.xml.

Search in multi-language content, with language specific stemming, stopwords, synonyms,

Boost your search with multi-media content (pdf, .xls, .doc), facet filters, autocompletion, suggestions, and optional hosting.

= Why Apache Solr ? =
Standard WP search is performed by SQL queries directly on the database. So do most of search plugins.
But SQL is awfully greedy in computer resources, especially when it comes to table joins and wild cards (select * where field like ‘%keyword%’), which are both heavily used by search.
And SQL can’t keep well with natural language: synonyms, language specific plurals, stop-words, …

Fortunately, performance and relevance are features built specifically in full-text search engines.
Using a search engine, you’ll be able to deliver more accurate search to your visitors, for far less computer resources, which means better for cheaper.

The purpose of this plugin is to help you setup your dear Wordpress search to your own Apache Solr server, or to a hosted Apache server.
Apache Solr is the World leading Open source full-text Search Engine. No question on that.

And now, with this plugin, you can get it for free. So, fasten your seat belt, and enjoy the trip.


= Features =

1. Benefit from Apache Solr for faster, better search results.
2. Incremental indexing: only new or updated posts are indexed. Perfect for tens of thousands of posts.
3. Real-time indexing: as soon as a post is published/unpublished, it is indexed/de-indexed. No outdated results are displayed.
3. Search in post attachements: pdf, .doc, .xls ...
4. Text-analysis to break down search phrases, to search entire phrase or individual words.
5. Advanced faceted search on fields such as tags, categories, author, and page type and custom fields.
6. Highlighted search words in the text.
7. Autocomplete suggestions, correct spelling mistakes
8. Provide a "Did you mean?" query suggestion.
9. Sorting based on time and number of comments.
10. Configuration options allow you to select pages to ignore.
11. Host Solr remotely using gotosolr.
12. Solr configuration made easy.
13. Multi-language search is supported with WPML.

For more details visit <a href='http://wpsolr.com'>wpsolr.com</a>



== Installation ==

1. Upload the WPSOLR-Search-Engine folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the 'WPSOLR' settings page and configure the plugin.
4. Please refer the Installation and User Guide for further reference.

== Screenshots ==

1. Admin: Download the Solr files solrconfig.xml and schema.xml
2. Admin: Configure your local Solr instance
3. Admin: Configure your cloud Solr instance
4. Admin: Indexing option (part 1)
5. Admin: Indexing option (part 2)
6. Admin: Options to display results
7. Admin: Add facets and control their order
8. Admin: Integration with the plugin 'groups'
9. Admin: Integration with the plugin 's2member'
10. Admin: Solr indexation
11. Front end: Auto suggestions while typing in search bar
12. Front end: Facets are displayed
13. Front end: Did you mean ?
14. Admin: Select attachment types to index
15. Admin: The "Sort by" items list is configurable
16. Admin: Change all front-end texts in admin

== Changelog ==

= 5.4 =
* Improve search speed by 2-3 times.
* Fix bug in category facet.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.

= 5.3 =
* Update documentation.

= 5.2 =
* New admin option to expand shortcodes found in posts content before indexing in Solr, rather than stripping them.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.
* Remove HTML and php tags from custom fields before indexing in Solr.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.
* New admin option to control the size of the results snippets (highlighting fragment size).
* New admin option to re-index all the posts, without deleting the index.

= 5.1 =
* Use custom fields also in search, autocomplete and suggestions (did you mean). Until now, custom fields where only displayed as facets.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.

= 5.0 =
* Fix error while updating the Solr index when post/page are published or trashed. 

= 4.9 =
* Fully support multi-language search form and search results with the plugin WPML (tested for WPML Multilingual CMS > 3.1.6).
* Use .mo files to translate the search form and search results front-end texts.
* Manage several Solr indexes.
* The search page is now /search-wpsolr (to be sure it does not exist yet). Migrate your /search-results page content if you customized it.

= 4.8 =
* Index the shortcodes content when stripping shortcodes tags.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.

= 4.7 =
* (Screenshot 6) A new option can prevent/enforce submitting the search form after selecting a value from the autocomplete list.

= 4.6 =
* Remove shortcodes from results by stripping shortcodes from documents indexed.
* WARNING: this will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.

= 4.5 =
* All front-end texts can be changed, with the dedicated admin screen (screenshot 16), or:
- With gettext() standard .po/.mo files
- With WPML string translation module
* Translation files are not delivered, but /lang/wpsolr.pot can be used to generate the .po and .mo files, or WPSOLR sources can be parsed to generate a .pot file (with poedit free tool for instance).
* Multi-language is not supported in Solr search, yet. Only the front-end texts can be multi-language.

= 4.4 =
* Fix several admin and front-end php notices

= 4.3 =
* Screenshot 15. The "Sort by" items list is configurable. You can choose not to diplay it at all, which elements it contains and in which order, which element is applied by default.
* WARNING: Your front-end sort list will not be displayed, until you configure it.

= 4.2 =
* You can now select which attachment type(s) you want to index (see screenshot 14).
* WARNING: If you already indexed attachments, you MUST now select which types you want, or the next time you start the indexing process, no attachments will be indexed.

= 4.1 =
* Attachments added and deleted are now synchronized with Solr in real-time (no need to sart the Solr indexing process).
* Fix message "Undefined variable: res_final".
* Fix message "Notice: ob_flush(): failed to flush buffer. No buffer to flush" in Solr operations ajax calls.

= 4.0 =
* Fix constant error DEFAULT_SOLR_TIMEOUT_IN_SECOND.

= 3.9 =
* Optional Cloud Solr hosting plans can now be chosen by those who are not familiar with Solr installation and configuration in a production environment.

= 3.8 =
* Categories are now indexed even when no custom taxonomy is selected in indexing option.

= 3.7 =
* Fix random error "undefined index: skey" when setting local Solr hosting.

= 3.6 =
* Fix JQuery issues on button emptying the index (not working on Safari, false errors displayed elsewhere).

= 3.5 =
* Add a debug checkbox on the indexing admin screen. By activating the debug mode, many details are displayed during the indexing process, to help solve difficult issues with Solr.

= 3.4 =
* Display errors occurring while deleting the Solr index data.
* Increase Solr timeout from 5 seconds to 30 seconds.

= 3.3 =
* Fix curl CA verification error when calling a Solr index protected with https.

= 3.2 =
* WPSOLR is now compatible with the latest Solr 5.x versions. Tested up to Solr 5.2.

= 3.1 =
* Fix bug on filters which prevented custom fields to be indexed.

= 3.0 =
* Prevent new posts/pages in status 'auto-draft' from calling Solr.

= 2.9 =
* Fix bug on Windows installations: "Warning: session_start(): Cannot send session cache limiter - headers already sent ".

= 2.8 =
* Fix bug which prevented some keywords to be highlighted in search results snippets.

= 2.7 =
* Fix bug which prevented partial search "tem1 term3" to match results, while "tem1 term2 term3" did.
* "Did you mean" now displays multiple terms suggestions. For instance "salr serch" can now suggest "solr search".

= 2.6 =
* WARNING: this version will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.
* Introduce a new filter for developpers to tweak custom fields sent to Solr

= 2.5 =
* Compatible with Solr 5.x: you'll need to use the new schema.xml

= 2.4 =
* WARNING: this version will require you to re-index all your documents. It can take a while if you have a large amount of documents in your WP database.
* Improved indexing process for large amount of data: the default batch size can be changed, timeouts are caught.

= 2.3 =
* Integration with <a href="https://wordpress.org/plugins/s2member/" target="_blank">s2member plugin</a>: filter Solr results with user levels and custom capabilities.

= 2.2 =
* Fix custom taxonomies to be searchable (they used to be displayed in facets only). As a side effect, <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> product taxonomies (product_cat , product_tag) are now searchable.

= 2.1 =
* Installation failed with PHP <= 5.3: fixed.

= 2.0 =
* Integration with <a href="https://wordpress.org/plugins/groups/" target="_blank">Groups plugin</a>: filter Solr results with user groups and posts capabilities.
* Stop the indexing process when attacements fail, and display the attachment name in error. Can be related to php security.

= 1.9 =
* Display thumbnail on page result lines.

= 1.8 =
* Do not open a new page when clicking on a page result line.

= 1.7 =
* Restart indexing at last document indexed (wether it fell in error, or timeout occured)
* Prevent index deletion when indexing starts
* Index post attachements
* Add attachements checkbox in menu Solr Options -> Indexing Options -> Post types to be indexed.
* Improve Solr error messages in Solr hosting tab, and Solr operations tab, including timeout messages.

= 1.6 =
* Can now index tens of thousands of documents without freezing or timeout

= 1.5 =
* Fixed an issue with older php versions. Should activate and work from PHP 5.2.4 at least.

= 1.4 =
* Fixed warning on search page for self hosted Solr
* Requires to reload yor index with the new config files (solrconfig.xml, schema.xml). Fixed error on autocomplete, and search page with "did you mean" activated, for self hosted Solr 

= 1.3 =
* Speed up search results display.

= 1.2 =
* Speed up autocompletion by 3 times.

= 1.1 =
* Improved error message when Solr port is blocked by hosting provider.
* Bug fix: Solr port used to be 4 digits. Can now be 2 digits and more.

= 1.0 =
* First version.


== Frequently Asked Questions ==

= Why the search page does not show up ?=
You have to select the admin option "Replace standard WP search", and verify that your urls permalinks are activated.

= Which PHP version is required ? =

WPSOLR uses a Solr client library, Solarium, which requires namespaces.

Namespaces are supported by PHP >= 5.3.0

= How do I install and configure Solr? =

Please refer to our detailed <a href='http://wpsolr.com/installation-guide/'>Installation Guide</a>.


= Can I host Solr on my server? =

Yes. But you can also host Solr remotely on gotosolr.


= What version of Solr does the WPSOLR Search Engine plugin need? =

WPSOLR Search Engine plugin is <a href="http://wpsolr.com/releases/#1.0"> compatible with the following Solr versions</a>. But if you were going with a new installation, we would recommend installing Solr version 3.6.x or above.


= Does WPSOLR Search Engine Plugin work with any version of WordPress? =

As of now, the WPSOLR Search Engine Plugin works with WordPress version 3.8 or above.


= Does WPSOLR Search Engine plugin handle custom post type, custom taxonomies and custom fields? =

Yes. The WPSOLR Search Engine plugin provides an option in dashboard, to select custom post types, custom taxonomies and custom fields, which have to be indexed.

 
= Can custom post type, custom taxonomies and custom fields be added faceted search? =

Yes. The WPSOLR Search Engine plugin provides option in dashboard, to select custom post types, custom taxonomies and custom fields, to be added in faceted search.


= Do you offer support? =

You can raise a support question for our plugin from wordpress.org
