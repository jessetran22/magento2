<?php
namespace Magento\AcceptanceTest\_RemoteStorageAwsS3EnabledSuite\Backend;

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
 * @Title("MC-38558: S3 - Export Bundle Products")
 * @Description("Verifies that a user can export Bundle and Simple child products for Bundled products             with a dynamic price, a fixed price, and a custom attribute. Verifies that the exported file and the             downloadable copy of the exported file contain the expected products. Note that MFTF cannot simply download             a file and have access to it due to the test not having access to the server that is running the test             browser. Therefore, this test verifies that the Download button can be successfully clicked, grabs the             request URL from the Download button, executes the request on the magento machine via a curl request, and             verifies the contents of the downloaded file. Uses S3 for the file system.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ExportBundleProductTest.xml<br>")
 * @TestCaseId("MC-38558")
 * @group importExport
 * @group remote_storage_aws_s3
 */
class AdminAwsS3ExportBundleProductTestCest
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
        $this->helperContainer->create("\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create bundle product with dynamic price with two simple products");
		$I->createEntity("firstSimpleProductForDynamic", "hook", "SimpleProduct2", [], []); // stepKey: firstSimpleProductForDynamic
		$I->createEntity("secondSimpleProductForDynamic", "hook", "SimpleProduct2", [], []); // stepKey: secondSimpleProductForDynamic
		$I->createEntity("createDynamicBundleProduct", "hook", "ApiBundleProduct", [], []); // stepKey: createDynamicBundleProduct
		$I->createEntity("createFirstBundleOption", "hook", "DropDownBundleOption", ["createDynamicBundleProduct"], []); // stepKey: createFirstBundleOption
		$I->createEntity("firstLinkOptionToDynamicProduct", "hook", "ApiBundleLink", ["createDynamicBundleProduct", "createFirstBundleOption", "firstSimpleProductForDynamic"], []); // stepKey: firstLinkOptionToDynamicProduct
		$I->createEntity("secondLinkOptionToDynamicProduct", "hook", "ApiBundleLink", ["createDynamicBundleProduct", "createFirstBundleOption", "secondSimpleProductForDynamic"], []); // stepKey: secondLinkOptionToDynamicProduct
		$I->comment("Create bundle product with fixed price with two simple products");
		$I->createEntity("firstSimpleProductForFixed", "hook", "SimpleProduct2", [], []); // stepKey: firstSimpleProductForFixed
		$I->createEntity("secondSimpleProductForFixed", "hook", "SimpleProduct2", [], []); // stepKey: secondSimpleProductForFixed
		$I->createEntity("createFixedBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createFixedBundleProduct
		$I->createEntity("createSecondBundleOption", "hook", "DropDownBundleOption", ["createFixedBundleProduct"], []); // stepKey: createSecondBundleOption
		$I->createEntity("firstLinkOptionToFixedProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createSecondBundleOption", "firstSimpleProductForFixed"], []); // stepKey: firstLinkOptionToFixedProduct
		$I->createEntity("secondLinkOptionToFixedProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createSecondBundleOption", "secondSimpleProductForFixed"], []); // stepKey: secondLinkOptionToFixedProduct
		$I->comment("Create bundle product with custom textarea attribute with two simple products");
		$I->createEntity("createProductAttribute", "hook", "productAttributeWysiwyg", [], []); // stepKey: createProductAttribute
		$I->createEntity("addToDefaultAttributeSet", "hook", "AddToDefaultSet", ["createProductAttribute"], []); // stepKey: addToDefaultAttributeSet
		$I->createEntity("createFixedBundleProductWithAttribute", "hook", "ApiFixedBundleProduct", ["addToDefaultAttributeSet"], []); // stepKey: createFixedBundleProductWithAttribute
		$I->createEntity("firstSimpleProductForFixedWithAttribute", "hook", "SimpleProduct2", [], []); // stepKey: firstSimpleProductForFixedWithAttribute
		$I->createEntity("secondSimpleProductForFixedWithAttribute", "hook", "SimpleProduct2", [], []); // stepKey: secondSimpleProductForFixedWithAttribute
		$I->createEntity("createBundleOptionWithAttribute", "hook", "DropDownBundleOption", ["createFixedBundleProductWithAttribute"], []); // stepKey: createBundleOptionWithAttribute
		$I->createEntity("firstLinkOptionToFixedProductWithAttribute", "hook", "ApiBundleLink", ["createFixedBundleProductWithAttribute", "createBundleOptionWithAttribute", "firstSimpleProductForFixedWithAttribute"], []); // stepKey: firstLinkOptionToFixedProductWithAttribute
		$I->createEntity("secondLinkOptionToFixedProductWithAttribute", "hook", "ApiBundleLink", ["createFixedBundleProductWithAttribute", "createBundleOptionWithAttribute", "secondSimpleProductForFixedWithAttribute"], []); // stepKey: secondLinkOptionToFixedProductWithAttribute
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("BIC workaround");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Data & Reindex");
		$I->deleteEntity("createDynamicBundleProduct", "hook"); // stepKey: deleteDynamicBundleProduct
		$I->deleteEntity("firstSimpleProductForDynamic", "hook"); // stepKey: deleteFirstSimpleProductForDynamic
		$I->deleteEntity("secondSimpleProductForDynamic", "hook"); // stepKey: deleteSecondSimpleProductForDynamic
		$I->deleteEntity("createFixedBundleProduct", "hook"); // stepKey: deleteFixedBundleProduct
		$I->deleteEntity("firstSimpleProductForFixed", "hook"); // stepKey: deleteFirstSimpleProductForFixed
		$I->deleteEntity("secondSimpleProductForFixed", "hook"); // stepKey: deleteSecondSimpleProductForFixed
		$I->deleteEntity("createFixedBundleProductWithAttribute", "hook"); // stepKey: deleteFixedBundleProductWithAttribute
		$I->deleteEntity("firstSimpleProductForFixedWithAttribute", "hook"); // stepKey: deleteFirstSimpleProductForFixedWithAttribute
		$I->deleteEntity("secondSimpleProductForFixedWithAttribute", "hook"); // stepKey: deleteSecondSimpleProductForFixedWithAttribute
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment('[deleteExportFileDirectory] \Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("import_export/export"); // stepKey: deleteExportFileDirectory
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Stories({"Export Products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAwsS3ExportBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Export Created Products");
		$I->comment("Entering Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToExportPageGoToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportPageOpenedGoToExportIndexPage
		$I->comment("Exiting Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->comment("Entering Action Group [exportCreatedProducts] ExportAllProductsActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeDropDownExportCreatedProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadExportCreatedProducts
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisibleExportCreatedProducts
		$I->selectOption("#file_format", "CSV"); // stepKey: selectFileFormatExportCreatedProducts
		$I->scrollTo("//*[@id='export_filter_container']/button"); // stepKey: scrollToContinueExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: scrollToContinueExportCreatedProductsWaitForPageLoad
		$I->waitForElementVisible("//*[@id='export_filter_container']/button", 30); // stepKey: waitForScrollExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitForScrollExportCreatedProductsWaitForPageLoad
		$I->click("//*[@id='export_filter_container']/button"); // stepKey: clickContinueButtonExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickContinueButtonExportCreatedProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickExportCreatedProducts
		$I->waitForText("Message is added to queue, wait to get your file soon. Make sure your cron job is running to export the file", 30, "#messages div.message-success"); // stepKey: seeSuccessMessageExportCreatedProducts
		$I->comment("Exiting Action Group [exportCreatedProducts] ExportAllProductsActionGroup");
		$I->comment("Start Message Queue for Export Consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start exportProcessor --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->reloadPage(); // stepKey: refreshPage
		$I->waitForPageLoad(30); // stepKey: waitForReload
		$I->waitForElementVisible("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content", 30); // stepKey: waitForFileName
		$getFilename = $I->grabTextFrom("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content"); // stepKey: getFilename
		$I->comment("Entering Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->waitForElementVisible("//tr[@data-repeat-index='0']//button", 30); // stepKey: waitForTheRowGrabNameFile
		$I->waitForPageLoad(30); // stepKey: waitForTheRowGrabNameFileWaitForPageLoad
		$grabDownloadUrlGrabNameFile = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabDownloadUrlGrabNameFile
		$I->waitForPageLoad(30); // stepKey: grabDownloadUrlGrabNameFileWaitForPageLoad
		$grabFilenameGrabNameFile = $I->executeJS("var href = '{$grabDownloadUrlGrabNameFile}';  return href.toQueryParams().filename;"); // stepKey: grabFilenameGrabNameFile
		$grabNameFile = $I->return($grabFilenameGrabNameFile); // stepKey: returnFilenameGrabNameFile
		$I->comment("Exiting Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->comment("Validate Export File on File System: Dynamic Bundle Product");
		$I->comment('[assertExportFileExists] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("import_export/export/{$grabNameFile}", ''); // stepKey: assertExportFileExists
		$I->comment('[assertExportFileContainsFirstSimpleProductForDynamicBundledProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('firstSimpleProductForDynamic', 'name', 'test'), ''); // stepKey: assertExportFileContainsFirstSimpleProductForDynamicBundledProduct
		$I->comment('[assertExportFileContainsSecondSimpleProductForDynamicBundledProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('secondSimpleProductForDynamic', 'name', 'test'), ''); // stepKey: assertExportFileContainsSecondSimpleProductForDynamicBundledProduct
		$I->comment('[assertExportFileContainsDynamicBundleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createDynamicBundleProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsDynamicBundleProduct
		$I->comment('[assertExportFileContainsDynamicBundleProductOption1] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createFirstBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createFirstBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createFirstBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForDynamic', 'sku', 'test'), ''); // stepKey: assertExportFileContainsDynamicBundleProductOption1
		$I->comment('[assertExportFileContainsDynamicBundleProductOption2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createFirstBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createFirstBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createFirstBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForDynamic', 'sku', 'test'), ''); // stepKey: assertExportFileContainsDynamicBundleProductOption2
		$I->comment('[assertExportFileContainsDynamicPriceBundleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "0.000000,,,," . $I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test'), ''); // stepKey: assertExportFileContainsDynamicPriceBundleProduct
		$I->comment("Validate Export File on File System: Fixed Bundle Product");
		$I->comment('[assertExportFileContainsFirstSimpleProductForFixedBundledProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('firstSimpleProductForFixed', 'name', 'test'), ''); // stepKey: assertExportFileContainsFirstSimpleProductForFixedBundledProduct
		$I->comment('[assertExportFileContainsSecondSimpleProductForFixedBundledProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('secondSimpleProductForFixed', 'name', 'test'), ''); // stepKey: assertExportFileContainsSecondSimpleProductForFixedBundledProduct
		$I->comment('[assertExportFileContainsFixedBundleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFixedBundleProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProduct
		$I->comment('[assertExportFileContainsFixedBundleProductOption1] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createSecondBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createSecondBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createSecondBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForFixed', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProductOption1
		$I->comment('[assertExportFileContainsFixedBundleProductOption2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createSecondBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createSecondBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createSecondBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForFixed', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProductOption2
		$I->comment('[assertExportFileContainsFixedPriceBundleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFixedBundleProduct', 'price', 'test') . "0000,,,," . $I->retrieveEntityField('createFixedBundleProduct', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedPriceBundleProduct
		$I->comment("Validate Export File on File System: Fixed Bundle Product with Attribute");
		$I->comment('[assertExportFileContainsFirstSimpleProductForFixedBundledProductWithAttribute] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('firstSimpleProductForFixedWithAttribute', 'name', 'test'), ''); // stepKey: assertExportFileContainsFirstSimpleProductForFixedBundledProductWithAttribute
		$I->comment('[assertExportFileContainsSecondSimpleProductForFixedBundledProductWithAttribute] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('secondSimpleProductForFixedWithAttribute', 'name', 'test'), ''); // stepKey: assertExportFileContainsSecondSimpleProductForFixedBundledProductWithAttribute
		$I->comment('[assertExportFileContainsFixedBundleProductWithAttribute] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'name', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProductWithAttribute
		$I->comment('[assertExportFileContainsFixedBundleProductWithAttributeOption1] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForFixedWithAttribute', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProductWithAttributeOption1
		$I->comment('[assertExportFileContainsFixedBundleProductWithAttributeOption2] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "name=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForFixedWithAttribute', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedBundleProductWithAttributeOption2
		$I->comment('[assertExportFileContainsFixedPriceBundleProductWithAttribute] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'price', 'test') . "0000,,,," . $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'sku', 'test'), ''); // stepKey: assertExportFileContainsFixedPriceBundleProductWithAttribute
		$I->comment("Download Export File");
		$I->comment("Entering Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadCreatedProductsWaitForPageLoad
		$I->comment("Exiting Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->comment("Validate Downloaded Export File on File System: Dynamic Bundle Product");
		$grabExportUrl = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabExportUrl
		$I->waitForPageLoad(30); // stepKey: grabExportUrlWaitForPageLoad
		$I->comment('[assertDownloadFileContainsFirstSimpleProductForDynamicBundledProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('firstSimpleProductForDynamic', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstSimpleProductForDynamicBundledProduct
		$I->comment('[assertDownloadFileContainsSecondSimpleProductForDynamicBundledProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('secondSimpleProductForDynamic', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondSimpleProductForDynamicBundledProduct
		$I->comment('[assertDownloadFileContainsDynamicBundleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createDynamicBundleProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDynamicBundleProduct
		$I->comment('[assertDownloadFileContainsDynamicBundleProductOption1] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createFirstBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createFirstBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createFirstBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForDynamic', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDynamicBundleProductOption1
		$I->comment('[assertDownloadFileContainsDynamicBundleProductOption2] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createFirstBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createFirstBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createFirstBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForDynamic', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDynamicBundleProductOption2
		$I->comment('[assertDownloadFileContainsDynamicPriceBundleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "0.000000,,,," . $I->retrieveEntityField('createDynamicBundleProduct', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDynamicPriceBundleProduct
		$I->comment("Validate Downloaded Export File on File System: Fixed Bundle Product");
		$I->comment('[assertDownloadFileContainsFirstSimpleProductForFixedBundledProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('firstSimpleProductForFixed', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstSimpleProductForFixedBundledProduct
		$I->comment('[assertDownloadFileContainsSecondSimpleProductForFixedBundledProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('secondSimpleProductForFixed', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondSimpleProductForFixedBundledProduct
		$I->comment('[assertDownloadFileContainsFixedBundleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFixedBundleProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProduct
		$I->comment('[assertDownloadFileContainsFixedBundleProductOption1] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createSecondBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createSecondBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createSecondBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForFixed', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProductOption1
		$I->comment('[assertDownloadFileContainsFixedBundleProductOption2] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createSecondBundleOption', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createSecondBundleOption', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createSecondBundleOption', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForFixed', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProductOption2
		$I->comment('[assertDownloadFileContainsFixedPriceBundleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFixedBundleProduct', 'price', 'test') . "0000,,,," . $I->retrieveEntityField('createFixedBundleProduct', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedPriceBundleProduct
		$I->comment("Validate Downloaded Export File on File System: Fixed Bundle Product with Attribute");
		$I->comment('[assertDownloadFileContainsFirstSimpleProductForFixedBundledProductWithAttribute] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('firstSimpleProductForFixedWithAttribute', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstSimpleProductForFixedBundledProductWithAttribute
		$I->comment('[assertDownloadFileContainsSecondSimpleProductForFixedBundledProductWithAttribute] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('secondSimpleProductForFixedWithAttribute', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondSimpleProductForFixedBundledProductWithAttribute
		$I->comment('[assertDownloadFileContainsFixedBundleProductWithAttribute] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProductWithAttribute
		$I->comment('[assertDownloadFileContainsFixedBundleProductWithAttributeOption1] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('firstSimpleProductForFixedWithAttribute', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProductWithAttributeOption1
		$I->comment('[assertDownloadFileContainsFixedBundleProductWithAttributeOption2] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "name=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[title]', 'test') . ",type=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[type]', 'test') . ",required=" . $I->retrieveEntityField('createBundleOptionWithAttribute', 'option[required]', 'test') . ",sku=" . $I->retrieveEntityField('secondSimpleProductForFixedWithAttribute', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedBundleProductWithAttributeOption2
		$I->comment('[assertDownloadFileContainsFixedPriceBundleProductWithAttribute] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'price', 'test') . "0000,,,," . $I->retrieveEntityField('createFixedBundleProductWithAttribute', 'sku', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFixedPriceBundleProductWithAttribute
		$I->comment("Delete Export File");
		$I->comment("Entering Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: goToExportIndexPageDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Delete']"); // stepKey: clickOnDeleteDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteExportedFile
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmDeleteDeleteExportedFile
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitFormReload2DeleteExportedFile
		$I->dontSeeElement("//div[@class='data-grid-cell-content'][text()='{$getFilename}']"); // stepKey: assertDontSeeFileDeleteExportedFile
		$I->comment("Exiting Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
		$I->comment('[assertExportFileDeleted] \Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileDoesNotExist()');
		$this->helperContainer->get('\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileDoesNotExist("import_export/export/{$grabNameFile}", ''); // stepKey: assertExportFileDeleted
		$I->comment("Validate Export File on File System: Dynamic Bundle Product");
		$I->comment("Validate Export File on File System: Fixed Bundle Product");
		$I->comment("Validate Export File on File System: Fixed Bundle Product with Attribute");
		$I->comment("Delete Export File");
	}
}
