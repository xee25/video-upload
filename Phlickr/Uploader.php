<?php
echo '<pre>';
/**
 * @version $Id: Uploader.php 529 2006-10-30 21:49:21Z drewish $
 * @author  Andrew Morton <drewish@katherinehouse.com>
 * @license http://opensource.org/licenses/lgpl-license.php
 *          GNU Lesser General Public License, Version 2.1
 * @package Phlickr
 */
const FLICKR_API_KEY = '008371898c160e0af3b3e63baf3c79da';
const FLICKR_API_SECRET = '4dfc4b3620f1ea31';
const FLICKR_TOKEN = '';
const FLICKR_API_TOKEN = '72157692464421972-eeda9d9452a8cce4';
/**
 * Phlickr_Api includes the core classes.
 */
require_once 'Phlickr/Api.php';
/**
 * One or more methods returns Phlickr_Photo objects.
 */
require_once 'Phlickr/AuthedPhoto.php';
/**
 * uploadBatch() uses this to create a photoset.
 */
require_once 'Phlickr/AuthedPhotosetList.php';
/**
 * uploadBatch() accepts Phlickr_Framework_IUploadBatch as a parameter.
 */
require_once 'Phlickr/Framework/IUploadBatch.php';
/**
 * uploadBatch() accepts Phlickr_Framework_IUploadListener as a parameter.
 */
require_once 'Phlickr/Framework/IUploadListener.php';

/**
 * Uploads photos to Flickr.
 *
* Sample usage:
 * <code>
 * <?php
 * require_once 'Phlickr/Api.php';
 * require_once 'Phlickr/Uploader.php';
 *
 * define('UPLOAD_DIRECTORY', 'D:\sf\phlickr\samples\files_to_testupload');
 * define('PHOTO_EXTENSION', '.jpg');
 *
 * // create an api
 * $api = new Phlickr_Api(FLICKR_API_KEY, FLICKR_API_SECRET, FLICKR_API_TOKEN);
 * // create an uploader
 * $uploader = new Phlickr_Uploader($api);
 * // array to keep track of the photo ids as they're uploaded
 * $photo_ids = array();
 * // create a DirectoryIterator (part of the Standard PHP Library)
 * $di = new DirectoryIterator(UPLOAD_DIRECTORY);
 *
 * // upload all the photos in the directory
 * foreach($di as $item) {
 *     // only upload files with the given extension
 *     if ($item->isFile()) {
 *         $extension = substr($item, - strlen(PHOTO_EXTENSION));
 *         if (strtolower($extension) === strtolower(PHOTO_EXTENSION)) {
 *             print "Uploading $item...\n";
 *             // upload the photo
 *             $id = $uploader->upload($item->getPathname(), 'a title',
 *                 'a description', 'some tags');
 *             // save the photo's id to an array
 *             $photo_id[] = $id;
 *         }
 *     }
 * }
 *
 * // print out the post-upload edit link.
 * if (count($photo_ids)) {
 *     printf("All done! If you care to make some changes:\n%s",
 *         $uploader->buildEditUrl($photo_ids));
 * }
 * ?>
 * </code>
 *
 *
 * This class is responsible for:
 * - Uploading a file to Flickr with the specified title, description, tags
 *   and permissions.
 *
 * To do this, makes use public static methods of the Phlickr_Request and
 * Phlickr_Response classes.
 *
 * @package Phlickr
 * @author  Andrew Morton <drewish@katherinehouse.com>
 * @since   0.1.0
 */

require_once 'Phlickr/Api.php';
require_once 'Phlickr/Uploader.php';

define('UPLOAD_DIRECTORY', 'G:\abc');
define('PHOTO_EXTENSION', '.png');

// create an api
$api = new Phlickr_Api(FLICKR_API_KEY, FLICKR_API_SECRET, FLICKR_API_TOKEN);
// create an uploader
$uploader = new Phlickr_Uploader($api);
// array to keep track of the photo ids as they're uploaded
$photo_ids = array();
// create a DirectoryIterator (part of the Standard PHP Library)
$di = new DirectoryIterator(UPLOAD_DIRECTORY);

// upload all the photos in the directory
foreach ($di as $item) {
// only upload files with the given extension
    if ($item->isFile()) {
        $extension = substr($item, -strlen(PHOTO_EXTENSION));
        if (strtolower($extension) === strtolower(PHOTO_EXTENSION)) {

            print "Uploading $item...\n";
            // upload the photo

            $id = $uploader->upload($item->getPathname(), 'a title',
                'a description', 'some tags');
            // save the photo's id to an array
            $photo_id[] = $id;
        }
    }
}

// print out the post-upload edit link.
if (count($photo_ids)) {
    printf("All done! If you care to make some changes:\n%s",
        $uploader->buildEditUrl($photo_ids));
}

