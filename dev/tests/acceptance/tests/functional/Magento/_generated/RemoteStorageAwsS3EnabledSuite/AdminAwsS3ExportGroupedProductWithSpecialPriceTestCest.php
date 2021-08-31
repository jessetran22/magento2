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
 * @Title("MC-38558: S3 - Export Grouped Products with Special Price")
 * @Description("Verifies that a user can export a Grouped product with a special price and Simple child             products. Verifies that exported file and the downloadable copy of the exported file contain the expected             products. Note that MFTF cannot simply download a file and have access to it due to the test not having             access to the server that is running the test browser. Therefore, this test verifies that the Download             button can be successfully clicked, grabs the request URL from the Download button, executes the request on             the magento machine via a curl request, and verifies the contents of the downloaded file. Uses S3 for the             file system.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ExportGroupedProductWithSpecialPriceTest.xml<br>")
 * @TestCaseId("MC-38558")
 * @group importExport
 * @group remote_storage_aws_s3
 */
class AdminAwsS3ExportGroupedProductWithSpecialPriceTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create first simple product and add special price");
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("specialPriceToFirstProduct", "hook", "specialProductPrice2", ["createFirstSimpleProduct"], []); // stepKey: specialPriceToFirstProduct
		$I->comment("Create second simple product and add special price");
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondSimpleProduct
		$I->createEntity("specialPriceToSecondProduct", "hook", "specialProductPrice2", ["createSecondSimpleProduct"], []); // stepKey: specialPriceToSecondProduct
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create group product with created below simple products");
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct2", ["createCategory"], []); // stepKey: createGroupedProduct
		$I->createEntity("addFirstProduct", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createFirstSimpleProduct"], []); // stepKey: addFirstProduct
		$I->updateEntity("addFirstProduct", "hook", "OneMoreSimpleProductLink",["createGroupedProduct", "createSecondSimpleProduct"]); // stepKey: addSecondProduct
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
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	public function AdminAwsS3ExportGroupedProductWithSpecialPriceTest(AcceptanceTester $I)
	{
		$I->comment("Export Created Products");
		$I->comment("Entering Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToExportPageGoToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportPageOpenedGoToExportIndexPage
		$I->comment("Exiting Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->comment("BIC workaround");
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
		$I->comment("Validate Export File on File System: Grouped Product with Special Price");
		$I->comment('[assertExportFileExists] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("import_export/export/{$grabNameFile}", ''); // stepKey: assertExportFileExists
		$I->comment('[assertExportFileContainsFirstSimpleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsFirstSimpleProduct
		$I->comment('[assertExportFileContainsSecondSimpleProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsSecondSimpleProduct
		$I->comment('[assertExportFileContainsGroupedProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createGroupedProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsGroupedProduct
		$I->comment('[assertExportFileContainsFirstChildGroupedProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createFirstSimpleProduct', 'sku', 'test') . "=" . $I->retrieveEntityField('createFirstSimpleProduct', 'quantity', 'test'), ''); // stepKey: assertExportFileContainsFirstChildGroupedProduct
		$I->comment('[assertExportFileContainsSecondChildGroupedProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createSecondSimpleProduct', 'sku', 'test') . "=" . $I->retrieveEntityField('createSecondSimpleProduct', 'quantity', 'test'), ''); // stepKey: assertExportFileContainsSecondChildGroupedProduct
		$I->comment("Download Export File");
		$I->comment("Entering Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadCreatedProductsWaitForPageLoad
		$I->comment("Exiting Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->comment("Validate Downloaded Export File: Grouped Product with Special Price");
		$grabExportUrl = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabExportUrl
		$I->waitForPageLoad(30); // stepKey: grabExportUrlWaitForPageLoad
		$I->comment('[assertDownloadFileContainsFirstSimpleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstSimpleProduct
		$I->comment('[assertDownloadFileContainsSecondSimpleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondSimpleProduct
		$I->comment('[assertDownloadFileContainsGroupedProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createGroupedProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsGroupedProduct
		$I->comment('[assertDownloadFileContainsFirstChildGroupedProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createFirstSimpleProduct', 'sku', 'test') . "=" . $I->retrieveEntityField('createFirstSimpleProduct', 'quantity', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstChildGroupedProduct
		$I->comment('[assertDownloadFileContainsSecondChildGroupedProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createSecondSimpleProduct', 'sku', 'test') . "=" . $I->retrieveEntityField('createSecondSimpleProduct', 'quantity', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondChildGroupedProduct
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
		$I->comment("Validate Export File on S3: Grouped Product with Special Price");
		$I->comment("Delete Export File");
	}
}
