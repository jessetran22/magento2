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
 * @Title("MC-38558: S3 - Export Downloadable Products with File Links")
 * @Description("Verifies that a user can export a Downloadable product with downloadable and sample file             links. Verifies that the exported file and the downloadable copy of the exported file contain the expected             product (a filter is applied when exporting such that ONLY the downloadable product row should be in the             export), the correct downloadable link with files, and the correct downloadable sample links with files.             Note that MFTF cannot simply download a file and have access to it due to the test not having access to the             server that is running the test browser. Therefore, this test verifies that the Download button can be             successfully clicked, grabs the request URL from the Download button, executes the request on the magento             machine via a curl request, and verifies the contents of the downloaded file. Uses S3 for the file system.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ExportDownloadableProductWithFileLinksTest.xml<br>")
 * @TestCaseId("MC-38558")
 * @group importExport
 * @group remote_storage_aws_s3
 */
class AdminAwsS3ExportDownloadableProductWithFileLinksTestCest
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
		$I->comment("Create Category, Create Downloadable Product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createProduct
		$I->createEntity("addDownloadableLink", "hook", "downloadableLink_Files", ["createProduct"], []); // stepKey: addDownloadableLink
		$I->createEntity("addDownloadableSamples", "hook", "downloadableSample_File2", ["createProduct"], []); // stepKey: addDownloadableSamples
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
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
		$I->comment("Delete Data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteConfigProduct
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
	public function AdminAwsS3ExportDownloadableProductWithFileLinksTest(AcceptanceTester $I)
	{
		$I->comment("Export Created Products");
		$I->comment("Entering Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToExportPageGoToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportPageOpenedGoToExportIndexPage
		$I->comment("Exiting Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->comment("Entering Action Group [exportProductBySku] ExportProductsFilterByAttributeActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeDropDownExportProductBySku
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionExportProductBySku
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadExportProductBySku
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisibleExportProductBySku
		$I->scrollTo("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: scrollToAttributeExportProductBySku
		$I->checkOption("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: selectAttributeExportProductBySku
		$I->fillField("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='text']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: setDataInFieldExportProductBySku
		$I->waitForPageLoad(30); // stepKey: waitForUserInputExportProductBySku
		$I->scrollTo("//*[@id='export_filter_container']/button"); // stepKey: scrollToContinueExportProductBySku
		$I->waitForPageLoad(30); // stepKey: scrollToContinueExportProductBySkuWaitForPageLoad
		$I->click("//*[@id='export_filter_container']/button"); // stepKey: clickContinueButtonExportProductBySku
		$I->waitForPageLoad(30); // stepKey: clickContinueButtonExportProductBySkuWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickExportProductBySku
		$I->waitForText("Message is added to queue, wait to get your file soon", 30, "#messages div.message-success"); // stepKey: seeSuccessMessageExportProductBySku
		$I->comment("Exiting Action Group [exportProductBySku] ExportProductsFilterByAttributeActionGroup");
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
		$I->comment("Validate Export File on File System");
		$I->comment('[assertExportFileExists] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileExists("import_export/export/{$grabNameFile}", ''); // stepKey: assertExportFileExists
		$I->comment('[assertExportFileContainsDownloadableProduct] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", $I->retrieveEntityField('createProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsDownloadableProduct
		$I->comment('[assertExportFileContainsDownloadableLink] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "title=" . $I->retrieveEntityField('addDownloadableLink', 'link[title]', 'test') . ",sort_order=" . $I->retrieveEntityField('addDownloadableLink', 'link[sort_order]', 'test') . ",sample_type=" . $I->retrieveEntityField('addDownloadableLink', 'link[sample_type]', 'test') . ",sample_file=/a/d/" . $I->retrieveEntityField('addDownloadableLink', 'link[sample_file_content][name]', 'test') . ",price=" . $I->retrieveEntityField('addDownloadableLink', 'link[price]', 'test') . "0000,number_of_downloads=" . $I->retrieveEntityField('addDownloadableLink', 'link[number_of_downloads]', 'test') . ",is_shareable=" . $I->retrieveEntityField('addDownloadableLink', 'link[is_shareable]', 'test') . ",link_type=" . $I->retrieveEntityField('addDownloadableLink', 'link[link_type]', 'test') . ",link_file=/m/a/" . $I->retrieveEntityField('addDownloadableLink', 'link[link_file_content][name]', 'test'), ''); // stepKey: assertExportFileContainsDownloadableLink
		$I->comment('[assertExportFileContainsDownloadableSampleLink] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->assertFileContainsString("import_export/export/{$grabNameFile}", "title=" . $I->retrieveEntityField('addDownloadableSamples', 'sample[title]', 'test') . ",sample_type=" . $I->retrieveEntityField('addDownloadableSamples', 'sample[sample_type]', 'test') . ",sample_file=/t/e/" . $I->retrieveEntityField('addDownloadableSamples', 'sample[sample_file_content][name]', 'test'), ''); // stepKey: assertExportFileContainsDownloadableSampleLink
		$I->comment("Download Export File");
		$I->comment("Entering Action Group [downloadExport] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadExport
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadExport
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadExport
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadExport
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadExportWaitForPageLoad
		$I->comment("Exiting Action Group [downloadExport] DownloadFileActionGroup");
		$I->comment("Validate Downloaded Export File on File System");
		$grabExportUrl = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabExportUrl
		$I->waitForPageLoad(30); // stepKey: grabExportUrlWaitForPageLoad
		$I->comment('[assertDownloadFileContainsDownloadableProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDownloadableProduct
		$I->comment('[assertDownloadFileContainsDownloadableLink] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "title=" . $I->retrieveEntityField('addDownloadableLink', 'link[title]', 'test') . ",sort_order=" . $I->retrieveEntityField('addDownloadableLink', 'link[sort_order]', 'test') . ",sample_type=" . $I->retrieveEntityField('addDownloadableLink', 'link[sample_type]', 'test') . ",sample_file=/a/d/" . $I->retrieveEntityField('addDownloadableLink', 'link[sample_file_content][name]', 'test') . ",price=" . $I->retrieveEntityField('addDownloadableLink', 'link[price]', 'test') . "0000,number_of_downloads=" . $I->retrieveEntityField('addDownloadableLink', 'link[number_of_downloads]', 'test') . ",is_shareable=" . $I->retrieveEntityField('addDownloadableLink', 'link[is_shareable]', 'test') . ",link_type=" . $I->retrieveEntityField('addDownloadableLink', 'link[link_type]', 'test') . ",link_file=/m/a/" . $I->retrieveEntityField('addDownloadableLink', 'link[link_file_content][name]', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDownloadableLink
		$I->comment('[assertDownloadFileContainsDownloadableSampleLink] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "title=" . $I->retrieveEntityField('addDownloadableSamples', 'sample[title]', 'test') . ",sample_type=" . $I->retrieveEntityField('addDownloadableSamples', 'sample[sample_type]', 'test') . ",sample_file=/t/e/" . $I->retrieveEntityField('addDownloadableSamples', 'sample[sample_file_content][name]', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsDownloadableSampleLink
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
		$I->comment("Validate Export File on S3");
		$I->comment("Delete Export File");
	}
}
