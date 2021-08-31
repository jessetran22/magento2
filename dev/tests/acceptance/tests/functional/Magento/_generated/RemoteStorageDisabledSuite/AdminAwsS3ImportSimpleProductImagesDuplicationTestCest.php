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
 * @Title("MC-42986: S3 - Duplicated images should not be created if the CSV file is imported more than once")
 * @Description("Duplicated images should not be created if the CSV file is imported more than once<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ImportSimpleProductImagesDuplicationTest.xml<br>")
 * @TestCaseId("MC-42986")
 * @group catalog_import_export
 * @group remote_storage_aws_s3
 * @group remote_storage_disabled
 */
class AdminAwsS3ImportSimpleProductImagesDuplicationTestCest
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
		$I->comment("Create Simple Product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['sku'] = "test_sku";
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->comment("Copy Images to Import Directory for Product Images");
		$I->comment('[createDirectoryForImportImages] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("pub/media/import/test_image_duplication", 511); // stepKey: createDirectoryForImportImages
		$I->comment('[copyProductBaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "pub/media/import/test_image_duplication/adobe-base.jpg"); // stepKey: copyProductBaseImage
		$I->comment('[copyProductSmallImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-small.jpg", "pub/media/import/test_image_duplication/adobe-small.jpg"); // stepKey: copyProductSmallImage
		$I->comment('[copyProductThumbImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-thumb.jpg", "pub/media/import/test_image_duplication/adobe-thumb.jpg"); // stepKey: copyProductThumbImage
		$enableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=" . getenv("REMOTE_STORAGE_AWSS3_DRIVER") . " --remote-storage-bucket=" . getenv("REMOTE_STORAGE_AWSS3_BUCKET") . " --remote-storage-region=" . getenv("REMOTE_STORAGE_AWSS3_REGION") . " --remote-storage-prefix=" . getenv("REMOTE_STORAGE_AWSS3_PREFIX") . " --remote-storage-key=" . getenv("REMOTE_STORAGE_AWSS3_ACCESS_KEY") . " --remote-storage-secret=" . getenv("REMOTE_STORAGE_AWSS3_SECRET_KEY") . " -n", 60); // stepKey: enableRemoteStorage
		$I->comment($enableRemoteStorage);
		$syncRemoteStorage = $I->magentoCLI("remote-storage:sync", 120); // stepKey: syncRemoteStorage
		$I->comment($syncRemoteStorage);
		$I->comment('[createDirectoryForImportFilesInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->createDirectory("var/import/images/test_image_duplication", 511); // stepKey: createDirectoryForImportFilesInS3
		$I->comment('[copyProductBaseImageS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/test_image_duplication/adobe-base.jpg", "var/import/images/test_image_duplication/adobe-base.jpg"); // stepKey: copyProductBaseImageS3
		$I->comment('[copyProductSmallImageS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/test_image_duplication/adobe-small.jpg", "var/import/images/test_image_duplication/adobe-small.jpg"); // stepKey: copyProductSmallImageS3
		$I->comment('[copyProductThumbImageS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/test_image_duplication/adobe-thumb.jpg", "var/import/images/test_image_duplication/adobe-thumb.jpg"); // stepKey: copyProductThumbImageS3
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Locally Copy Import Files to Unique Media Import Directory");
		$I->comment("Enable AWS S3 Remote Storage & Sync");
		$I->comment("Copy to Import Directory in AWS S3");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment('[deleteImportFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("media/import/test_image_duplication"); // stepKey: deleteImportFilesDirectoryS3
		$I->comment('[deleteImportImagesFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("var/import/images/test_image_duplication"); // stepKey: deleteImportImagesFilesDirectoryS3
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$disableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=file -n", 60); // stepKey: disableRemoteStorage
		$I->comment($disableRemoteStorage);
		$I->comment('[deleteImportFilesDirectoryLocal] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("pub/media/import/test_image_duplication"); // stepKey: deleteImportFilesDirectoryLocal
		$I->comment("Delete S3 Data");
		$I->comment("Disable AWS S3 Remote Storage & Delete Local Data");
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
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAwsS3ImportSimpleProductImagesDuplicationTest(AcceptanceTester $I)
	{
		$I->comment("Import product with add/update behavior");
		$I->comment("Entering Action Group [importCSVFile1] AdminImportProductsWithCustomImagesDirectoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportCSVFile1
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportCSVFile1
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportCSVFile1
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportCSVFile1
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportCSVFile1
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportCSVFile1
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportCSVFile1
		$I->attachFile("#import_file", "import_simple_product_with_image.csv"); // stepKey: attachFileForImportImportCSVFile1
		$I->fillField("#import_images_file_dir", "test_image_duplication"); // stepKey: fillImagesFileDirectoryFieldImportCSVFile1
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportCSVFile1
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportCSVFile1WaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportCSVFile1
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportCSVFile1WaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportCSVFile1
		$I->see("Created: 0, Updated: 1, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportCSVFile1
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportCSVFile1
		$I->comment("Exiting Action Group [importCSVFile1] AdminImportProductsWithCustomImagesDirectoryActionGroup");
		$I->comment("Verify images and their roles");
		$I->comment("Entering Action Group [openProduct1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenProduct1
		$I->comment("Exiting Action Group [openProduct1] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [assertBaseImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertBaseImageIsPresent1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBaseImageIsPresent1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertBaseImageIsPresent1
		$I->comment("Exiting Action Group [assertBaseImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: assertBaseImageRole1
		$I->comment("Entering Action Group [assertSmallImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSmallImageIsPresent1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSmallImageIsPresent1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-small')]", 30); // stepKey: seeImageAssertSmallImageIsPresent1
		$I->comment("Exiting Action Group [assertSmallImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-small')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: assertSmallImageRole1
		$I->comment("Entering Action Group [assertThumbImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertThumbImageIsPresent1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertThumbImageIsPresent1
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-thumb')]", 30); // stepKey: seeImageAssertThumbImageIsPresent1
		$I->comment("Exiting Action Group [assertThumbImageIsPresent1] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-thumb')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: assertThumbImageRole1
		$I->comment("Verify that only 3 images are present");
		$I->seeNumberOfElements("#media_gallery_content img", "3"); // stepKey: seeThreeImages1
		$I->comment("Import product with add/update behavior");
		$I->comment("Entering Action Group [importCSVFile2] AdminImportProductsWithCustomImagesDirectoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportCSVFile2
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportCSVFile2
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportCSVFile2
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportCSVFile2
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportCSVFile2
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportCSVFile2
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportCSVFile2
		$I->attachFile("#import_file", "import_simple_product_with_image.csv"); // stepKey: attachFileForImportImportCSVFile2
		$I->fillField("#import_images_file_dir", "test_image_duplication"); // stepKey: fillImagesFileDirectoryFieldImportCSVFile2
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportCSVFile2
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportCSVFile2WaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportCSVFile2
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportCSVFile2WaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportCSVFile2
		$I->see("Created: 0, Updated: 1, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportCSVFile2
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportCSVFile2
		$I->comment("Exiting Action Group [importCSVFile2] AdminImportProductsWithCustomImagesDirectoryActionGroup");
		$I->comment("Verify images and their roles");
		$I->comment("Entering Action Group [openProduct2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenProduct2
		$I->comment("Exiting Action Group [openProduct2] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [assertBaseImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertBaseImageIsPresent2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBaseImageIsPresent2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertBaseImageIsPresent2
		$I->comment("Exiting Action Group [assertBaseImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: assertBaseImageRole2
		$I->comment("Entering Action Group [assertSmallImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSmallImageIsPresent2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSmallImageIsPresent2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-small')]", 30); // stepKey: seeImageAssertSmallImageIsPresent2
		$I->comment("Exiting Action Group [assertSmallImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-small')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: assertSmallImageRole2
		$I->comment("Entering Action Group [assertThumbImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertThumbImageIsPresent2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertThumbImageIsPresent2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-thumb')]", 30); // stepKey: seeImageAssertThumbImageIsPresent2
		$I->comment("Exiting Action Group [assertThumbImageIsPresent2] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-thumb')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: assertThumbImageRole2
		$I->comment("Verify that only 3 images are present");
		$I->seeNumberOfElements("#media_gallery_content img", "3"); // stepKey: seeThreeImages2
	}
}
