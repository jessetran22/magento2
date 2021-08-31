<?php
namespace Magento\AcceptanceTest\_RemoteStorageDisabledSuite\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-38938: S3 - Verify Media Files Are Synced")
 * @Description("Verifies that media files are synced from local file system to AWS S3 by creating a             product with images while using the local file system, switching and syncing to S3, deleting the local             file system images, and verifying that the product images still render.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3SyncMediaFilesTest.xml<br>")
 * @TestCaseId("MC-38938")
 * @group remote_storage_aws_s3
 * @group remote_storage_disabled
 */
class AdminAwsS3SyncMediaFilesTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Category, Product, & Product Images");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createProductImage1", "hook", "ApiProductAttributeMediaGalleryEntryBluePng", ["createProduct"], []); // stepKey: createProductImage1
		$I->createEntity("createProductImage2", "hook", "ApiProductAttributeMediaGalleryEntryRedPng", ["createProduct"], []); // stepKey: createProductImage2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Data & Disable AWS S3 Remote Storage");
		$disableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=file -n", 60); // stepKey: disableRemoteStorage
		$I->comment($disableRemoteStorage);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"AwsS3"})
	 * @Stories({"Sync Files"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAwsS3SyncMediaFilesTest(AcceptanceTester $I)
	{
		$I->comment("Note: Due to MFTF bug, must wrap entity reference in curly braces for entity to resolve");
		$firstCharacterImage1FileName = $I->executeJS("return '{" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "}'.charAt(1)"); // stepKey: firstCharacterImage1FileName
		$secondCharacterImage1FileName = $I->executeJS("return '{" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "}'.charAt(2)"); // stepKey: secondCharacterImage1FileName
		$firstCharacterImage2FileName = $I->executeJS("return '{" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "}'.charAt(1)"); // stepKey: firstCharacterImage2FileName
		$secondCharacterImage2FileName = $I->executeJS("return '{" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "}'.charAt(2)"); // stepKey: secondCharacterImage2FileName
		$I->comment("Verify Images Are in Local File System");
		$I->comment('[assertLocalImage1Exists] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileExists("pub/media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage1Exists
		$I->comment('[assertLocalImage2Exists] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileExists("pub/media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage2Exists
		$I->comment("Local - Verify Images on Product Storefront Page");
		$I->comment("Entering Action Group [goToProductOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductOnStorefront
		$I->comment("Exiting Action Group [goToProductOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeFirstImage1
		$firstImageSrc1 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", "src"); // stepKey: firstImageSrc1
		$I->comment('[assertFirstImageContent1] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($firstImageSrc1, "55942e709d0a1c85d5174839c2e55cea", NULL, NULL, "Url: \"{$firstImageSrc1}\" did not render image: 55942e709d0a1c85d5174839c2e55cea"); // stepKey: assertFirstImageContent1
		$I->click(".fotorama__nav__shaft img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']"); // stepKey: clickSecondImage
		$I->waitForPageLoad(30); // stepKey: clickSecondImageWaitForPageLoad
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeSecondImage1
		$secondImageSrc1 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", "src"); // stepKey: secondImageSrc1
		$I->comment('[assertSecondImageContent1] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($secondImageSrc1, "5da9660dc7c0536210547e0000f9a9cf", NULL, NULL, "Url: \"{$secondImageSrc1}\" did not render image: 5da9660dc7c0536210547e0000f9a9cf"); // stepKey: assertSecondImageContent1
		$I->comment("Enable AWS S3 Remote Storage & Sync");
		$enableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=" . getenv("REMOTE_STORAGE_AWSS3_DRIVER") . " --remote-storage-bucket=" . getenv("REMOTE_STORAGE_AWSS3_BUCKET") . " --remote-storage-region=" . getenv("REMOTE_STORAGE_AWSS3_REGION") . " --remote-storage-prefix=" . getenv("REMOTE_STORAGE_AWSS3_PREFIX") . " --remote-storage-key=" . getenv("REMOTE_STORAGE_AWSS3_ACCESS_KEY") . " --remote-storage-secret=" . getenv("REMOTE_STORAGE_AWSS3_SECRET_KEY") . " -n", 60); // stepKey: enableRemoteStorage
		$I->comment($enableRemoteStorage);
		$syncRemoteStorage = $I->magentoCLI("remote-storage:sync", 120); // stepKey: syncRemoteStorage
		$I->comment($syncRemoteStorage);
		$I->comment("Verify Images Are in AWS S3");
		$I->comment('[assertS3Image1Exists] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertS3Image1Exists
		$I->comment('[assertS3Image2Exists] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertS3Image2Exists
		$I->comment('[assertS3CacheDirectoryNotEmpty] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertDirectoryNotEmpty()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertDirectoryNotEmpty("media/catalog/product/cache/", ''); // stepKey: assertS3CacheDirectoryNotEmpty
		$I->comment("S3 - Clear Caches & Verify Images on Product Storefront Page");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToCacheManagementPage] AdminGoToCacheManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageGoToCacheManagementPage
		$I->comment("Exiting Action Group [goToCacheManagementPage] AdminGoToCacheManagementPageActionGroup");
		$I->comment("Entering Action Group [clearCatalogImageCache] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->waitForElementVisible("#flushCatalogImages", 30); // stepKey: waitForFlushCatalogImagesCacheButtonClearCatalogImageCache
		$I->click("#flushCatalogImages"); // stepKey: clickFlushCatalogImagesCacheButtonClearCatalogImageCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCatalogImageCache
		$I->waitForText("The image cache was cleaned.", 30, "#messages div.message-success"); // stepKey: waitForSuccessMessageClearCatalogImageCache
		$I->comment("Exiting Action Group [clearCatalogImageCache] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->comment('[assertS3CacheDirectoryEmpty] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertDirectoryEmpty()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertDirectoryEmpty("media/catalog/product/cache/", ''); // stepKey: assertS3CacheDirectoryEmpty
		$I->comment("Entering Action Group [flushPageCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushPageCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushPageCache
		$I->comment($flushSpecifiedCacheFlushPageCache);
		$I->comment("Exiting Action Group [flushPageCache] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [goToProductOnStorefront2] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductOnStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductOnStorefront2
		$I->comment("Exiting Action Group [goToProductOnStorefront2] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeFirstImage2
		$firstImageSrc2 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", "src"); // stepKey: firstImageSrc2
		$I->comment('[assertFirstImageContent2] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($firstImageSrc2, "55942e709d0a1c85d5174839c2e55cea", NULL, NULL, "Url: \"{$firstImageSrc2}\" did not render image: 55942e709d0a1c85d5174839c2e55cea"); // stepKey: assertFirstImageContent2
		$I->click(".fotorama__nav__shaft img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']"); // stepKey: clickSecondImage2
		$I->waitForPageLoad(30); // stepKey: clickSecondImage2WaitForPageLoad
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeSecondImage2
		$secondImageSrc2 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", "src"); // stepKey: secondImageSrc2
		$I->comment('[assertSecondImageContent2] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($secondImageSrc2, "5da9660dc7c0536210547e0000f9a9cf", NULL, NULL, "Url: \"{$secondImageSrc2}\" did not render image: 5da9660dc7c0536210547e0000f9a9cf"); // stepKey: assertSecondImageContent2
		$I->comment("Delete Images on Local File System");
		$I->comment('[deleteLocalImage1] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteFileIfExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteFileIfExists("pub/media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test')); // stepKey: deleteLocalImage1
		$I->comment('[assertLocalImage1IsDeleted] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage1IsDeleted
		$I->comment('[deleteLocalImage2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteFileIfExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteFileIfExists("pub/media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test')); // stepKey: deleteLocalImage2
		$I->comment('[assertLocalImage2IsDeleted] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage2IsDeleted
		$I->comment('[deleteLocalCacheDirectory] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("pub/media/catalog/product/cache/"); // stepKey: deleteLocalCacheDirectory
		$I->comment('[assertLocalCacheDirectoryDeleted] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/cache/", ''); // stepKey: assertLocalCacheDirectoryDeleted
		$I->comment("S3 - Clean Cache & Verify Images on Product Storefront Page");
		$I->comment("Entering Action Group [goToCacheManagementPage2] AdminGoToCacheManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageGoToCacheManagementPage2
		$I->comment("Exiting Action Group [goToCacheManagementPage2] AdminGoToCacheManagementPageActionGroup");
		$I->comment("Entering Action Group [clearCatalogImageCache2] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->waitForElementVisible("#flushCatalogImages", 30); // stepKey: waitForFlushCatalogImagesCacheButtonClearCatalogImageCache2
		$I->click("#flushCatalogImages"); // stepKey: clickFlushCatalogImagesCacheButtonClearCatalogImageCache2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCatalogImageCache2
		$I->waitForText("The image cache was cleaned.", 30, "#messages div.message-success"); // stepKey: waitForSuccessMessageClearCatalogImageCache2
		$I->comment("Exiting Action Group [clearCatalogImageCache2] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->comment('[assertS3CacheDirectoryEmpty2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertDirectoryEmpty()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertDirectoryEmpty("media/catalog/product/cache/", ''); // stepKey: assertS3CacheDirectoryEmpty2
		$I->comment("Entering Action Group [flushPageCache2] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushPageCache2 = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushPageCache2
		$I->comment($flushSpecifiedCacheFlushPageCache2);
		$I->comment("Exiting Action Group [flushPageCache2] CliCacheFlushActionGroup");
		$I->comment("Assert Local File System Images & Cached Images Are Still Non-Existent");
		$I->comment('[assertLocalImage1IsDeleted2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage1IsDeleted2
		$I->comment('[assertLocalImage2IsDeleted2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage2IsDeleted2
		$I->comment('[assertLocalCacheDirectoryDeleted2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/cache/", ''); // stepKey: assertLocalCacheDirectoryDeleted2
		$I->comment("Open Product on Storefront, Assert S3 Images Exist & Get Cached, Assert Local File System Images & Cache Are Still Non-Existent");
		$I->comment("Entering Action Group [goToProductOnStorefront3] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductOnStorefront3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductOnStorefront3
		$I->comment("Exiting Action Group [goToProductOnStorefront3] StorefrontOpenProductEntityPageActionGroup");
		$I->comment('[assertS3Image1Exists2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertS3Image1Exists2
		$I->comment('[assertS3Image2Exists2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertS3Image2Exists2
		$I->comment('[assertS3CacheDirectoryNotEmpty2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertDirectoryNotEmpty()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertDirectoryNotEmpty("media/catalog/product/cache/", ''); // stepKey: assertS3CacheDirectoryNotEmpty2
		$I->comment('[assertLocalImage1IsDeleted3] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage1FileName}/{$secondCharacterImage1FileName}/" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage1IsDeleted3
		$I->comment('[assertLocalImage2IsDeleted3] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/{$firstCharacterImage2FileName}/{$secondCharacterImage2FileName}/" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test'), ''); // stepKey: assertLocalImage2IsDeleted3
		$I->comment('[assertLocalCacheDirectoryGone] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/cache/", ''); // stepKey: assertLocalCacheDirectoryGone
		$I->comment("Verify Product Images Render Correctly When Images Initially Only Exist in S3");
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeFirstImage3
		$firstImageSrc3 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", "src"); // stepKey: firstImageSrc3
		$I->comment('[assertFirstImageContent3] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($firstImageSrc3, "55942e709d0a1c85d5174839c2e55cea", NULL, NULL, "Url: \"{$firstImageSrc3}\" did not render image: 55942e709d0a1c85d5174839c2e55cea"); // stepKey: assertFirstImageContent3
		$I->click(".fotorama__nav__shaft img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']"); // stepKey: clickSecondImage3
		$I->waitForPageLoad(30); // stepKey: clickSecondImage3WaitForPageLoad
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeSecondImage3
		$secondImageSrc3 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", "src"); // stepKey: secondImageSrc3
		$I->comment('[assertSecondImageContent3] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($secondImageSrc3, "5da9660dc7c0536210547e0000f9a9cf", NULL, NULL, "Url: \"{$secondImageSrc3}\" did not render image: 5da9660dc7c0536210547e0000f9a9cf"); // stepKey: assertSecondImageContent3
		$I->comment("Disable AWS S3 Remote Storage, Clean Cache & Verify Images Do Not Appear on Product Storefront Page");
		$disableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=file -n", 60); // stepKey: disableRemoteStorage
		$I->comment($disableRemoteStorage);
		$I->comment("Entering Action Group [goToCacheManagementPage3] AdminGoToCacheManagementPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageGoToCacheManagementPage3
		$I->comment("Exiting Action Group [goToCacheManagementPage3] AdminGoToCacheManagementPageActionGroup");
		$I->comment("Entering Action Group [clearCatalogImageCache3] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->waitForElementVisible("#flushCatalogImages", 30); // stepKey: waitForFlushCatalogImagesCacheButtonClearCatalogImageCache3
		$I->click("#flushCatalogImages"); // stepKey: clickFlushCatalogImagesCacheButtonClearCatalogImageCache3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCatalogImageCache3
		$I->waitForText("The image cache was cleaned.", 30, "#messages div.message-success"); // stepKey: waitForSuccessMessageClearCatalogImageCache3
		$I->comment("Exiting Action Group [clearCatalogImageCache3] AdminClickFlushCatalogImagesCacheActionGroup");
		$I->comment('[assertLocalCacheDirectoryEmpty2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertPathDoesNotExist()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertPathDoesNotExist("pub/media/catalog/product/cache/", ''); // stepKey: assertLocalCacheDirectoryEmpty2
		$I->comment("Entering Action Group [flushPageCache3] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushPageCache3 = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushPageCache3
		$I->comment($flushSpecifiedCacheFlushPageCache3);
		$I->comment("Exiting Action Group [flushPageCache3] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [goToProductOnStorefront4] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductOnStorefront4
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductOnStorefront4
		$I->comment("Exiting Action Group [goToProductOnStorefront4] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeFirstImage4
		$firstImageSrc4 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage2', 'entry[content][name]', 'test') . "']", "src"); // stepKey: firstImageSrc4
		$I->comment('[assertFirstImageContent4] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($firstImageSrc4, "c0459a796c5b8ee74254472c235a7460", NULL, NULL, "Url: \"{$firstImageSrc4}\" did not render image: c0459a796c5b8ee74254472c235a7460"); // stepKey: assertFirstImageContent4
		$I->click(".fotorama__nav__shaft img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']"); // stepKey: clickSecondImage4
		$I->waitForPageLoad(30); // stepKey: clickSecondImage4WaitForPageLoad
		$I->waitForElementVisible(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", 30); // stepKey: seeSecondImage4
		$secondImageSrc4 = $I->grabAttributeFrom(".product.media div[data-active=true] > img[src*='" . $I->retrieveEntityField('createProductImage1', 'entry[content][name]', 'test') . "']", "src"); // stepKey: secondImageSrc4
		$I->comment('[assertSecondImageContent4] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertImageContentIsEqual()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertImageContentIsEqual($secondImageSrc4, "c0459a796c5b8ee74254472c235a7460", NULL, NULL, "Url: \"{$secondImageSrc4}\" did not render image: c0459a796c5b8ee74254472c235a7460"); // stepKey: assertSecondImageContent4
	}
}
