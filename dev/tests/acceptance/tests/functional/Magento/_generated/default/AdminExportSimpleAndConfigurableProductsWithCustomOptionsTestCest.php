<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MC-14005: Export Simple and Configurable Products with Custom Options")
 * @Description("Verifies that a user can export a Configurable product with child simple products with             custom options. Verifies that the exported file and the downloadable copy of the exported file contain the             expected product (a filter is applied when exporting such that ONLY the configurable product row should be             in the export). Note that MFTF cannot simply download a file and have access to it due to the test not             having access to the server that is running the test browser. Therefore, this test verifies that the             Download button can be successfully clicked, grabs the request URL from the Download button, executes the             request on the magento machine via a curl request, and verifies the contents of the downloaded file.<h3>Test files</h3>app/code/Magento/CatalogImportExport/Test/Mftf/Test/AdminExportSimpleAndConfigurableProductsWithCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-14005")
 * @group catalog_import_export
 * @group mtf_migrated
 */
class AdminExportSimpleAndConfigurableProductsWithCustomOptionsTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create configurable product with two attributes");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeFirstOption
		$I->createEntity("createConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeSecondOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeFirstOption
		$I->getEntity("getConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeSecondOption
		$I->comment("Add custom options to configurable product");
		$I->updateEntity("createConfigProduct", "hook", "productWithOptions",[]); // stepKey: updateProductWithOptions
		$I->comment("Create two simple product which will be the part of configurable product");
		$I->createEntity("createConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeFirstOption"], []); // stepKey: createConfigFirstChildProduct
		$I->createEntity("createConfigSecondChildProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeSecondOption"], []); // stepKey: createConfigSecondChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeFirstOption", "getConfigAttributeSecondOption"], []); // stepKey: createConfigProductOption
		$I->comment("Add created below children products to configurable product");
		$I->createEntity("createConfigProductAddFirstChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigFirstChildProduct"], []); // stepKey: createConfigProductAddFirstChild
		$I->createEntity("createConfigProductAddSecondChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigSecondChildProduct"], []); // stepKey: createConfigProductAddSecondChild
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product creation");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigFirstChildProduct", "hook"); // stepKey: deleteConfigFirstChildProduct
		$I->deleteEntity("createConfigSecondChildProduct", "hook"); // stepKey: deleteConfigSecondChildProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment('[deleteExportFileDirectory] \Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("var/export"); // stepKey: deleteExportFileDirectory
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"CatalogImportExport"})
	 * @Stories({"Export Products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminExportSimpleAndConfigurableProductsWithCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Export Created Products");
		$I->comment("Entering Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToExportPageGoToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportPageOpenedGoToExportIndexPage
		$I->comment("Exiting Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->comment("BIC workaround");
		$I->comment("Entering Action Group [exportProductBySku] ExportProductsFilterByAttributeActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeDropDownExportProductBySku
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionExportProductBySku
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadExportProductBySku
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisibleExportProductBySku
		$I->scrollTo("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: scrollToAttributeExportProductBySku
		$I->checkOption("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: selectAttributeExportProductBySku
		$I->fillField("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='text']", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: setDataInFieldExportProductBySku
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
		$I->comment("Validate Export File on File System: Product with Custom Options");
		$I->comment('[assertExportFileExists] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileExists("var/export/{$grabNameFile}", ''); // stepKey: assertExportFileExists
		$I->comment('[assertExportFileContainsConfigurableProduct] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileContainsString("var/export/{$grabNameFile}", $I->retrieveEntityField('createConfigProduct', 'name', 'test'), ''); // stepKey: assertExportFileContainsConfigurableProduct
		$I->comment('[assertExportFileContainsFirstChildSimpleProductOption] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileContainsString("var/export/{$grabNameFile}", "sku=" . $I->retrieveEntityField('createConfigFirstChildProduct', 'sku', 'test') . "," . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test') . "=option1", ''); // stepKey: assertExportFileContainsFirstChildSimpleProductOption
		$I->comment('[assertExportFileContainsSecondChildSimpleProductOption] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileContainsString()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileContainsString("var/export/{$grabNameFile}", "sku=" . $I->retrieveEntityField('createConfigSecondChildProduct', 'sku', 'test') . "," . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test') . "=option2", ''); // stepKey: assertExportFileContainsSecondChildSimpleProductOption
		$I->comment('[assertExportFileDoesNotContainFirstSimpleProduct] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileDoesNotContainString()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileDoesNotContainString("var/export/{$grabNameFile}", $I->retrieveEntityField('createConfigFirstChildProduct', 'name', 'test'), ''); // stepKey: assertExportFileDoesNotContainFirstSimpleProduct
		$I->comment('[assertExportFileDoesNotContainSecondSimpleProduct] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileDoesNotContainString()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileDoesNotContainString("var/export/{$grabNameFile}", $I->retrieveEntityField('createConfigSecondChildProduct', 'name', 'test'), ''); // stepKey: assertExportFileDoesNotContainSecondSimpleProduct
		$I->comment("Download Export File");
		$I->comment("Entering Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadCreatedProductsWaitForPageLoad
		$I->comment("Exiting Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->comment("Validate Downloaded Export File: Product with Custom Options");
		$grabExportUrl = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabExportUrl
		$I->waitForPageLoad(30); // stepKey: grabExportUrlWaitForPageLoad
		$I->comment('[assertDownloadFileContainsConfigurableProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, $I->retrieveEntityField('createConfigProduct', 'name', 'test'), NULL, 'admin', ''); // stepKey: assertDownloadFileContainsConfigurableProduct
		$I->comment('[assertDownloadFileContainsFirstChildSimpleProductOption] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "sku=" . $I->retrieveEntityField('createConfigFirstChildProduct', 'sku', 'test') . "," . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test') . "=option1", NULL, 'admin', ''); // stepKey: assertDownloadFileContainsFirstChildSimpleProductOption
		$I->comment('[assertDownloadFileContainsSecondChildSimpleProductOption] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "sku=" . $I->retrieveEntityField('createConfigSecondChildProduct', 'sku', 'test') . "," . $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test') . "=option2", NULL, 'admin', ''); // stepKey: assertDownloadFileContainsSecondChildSimpleProductOption
		$I->comment('[assertDownloadFileDoesNotContainFirstSimpleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseDoesNotContainString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseDoesNotContainString($grabExportUrl, $I->retrieveEntityField('createConfigFirstChildProduct', 'name', 'test'), NULL, 'admin'); // stepKey: assertDownloadFileDoesNotContainFirstSimpleProduct
		$I->comment('[assertDownloadFileDoesNotContainSecondSimpleProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseDoesNotContainString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseDoesNotContainString($grabExportUrl, $I->retrieveEntityField('createConfigSecondChildProduct', 'name', 'test'), NULL, 'admin'); // stepKey: assertDownloadFileDoesNotContainSecondSimpleProduct
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
		$I->comment('[assertExportFileDeleted] \Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileDoesNotExist()');
		$this->helperContainer->get('\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileDoesNotExist("var/export/{$grabNameFile}", ''); // stepKey: assertExportFileDeleted
	}
}
