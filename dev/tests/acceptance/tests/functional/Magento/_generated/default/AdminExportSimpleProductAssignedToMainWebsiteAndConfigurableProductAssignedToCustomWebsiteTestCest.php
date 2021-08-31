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
 * @Title("MC-14006: Export Simple Product assigned to Main Website and Configurable Product assigned to Custom Website")
 * @Description("Admin should be able to export Simple Product assigned to Main Website and Configurable Product assigned to Custom Website<h3>Test files</h3>app/code/Magento/CatalogImportExport/Test/Mftf/Test/AdminExportSimpleProductAssignedToMainWebsiteAndConfigurableProductAssignedToCustomWebsiteTest.xml<br>")
 * @TestCaseId("MC-14006")
 * @group catalog_import_export
 * @group mtf_migrated
 */
class AdminExportSimpleProductAssignedToMainWebsiteAndConfigurableProductAssignedToCustomWebsiteTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create simple product");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Create configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeFirstOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeFirstOption
		$I->createEntity("createConfigProductAttributeSecondOption", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeSecondOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeFirstOption
		$I->getEntity("getConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeSecondOption
		$I->comment("Create two simple product which will be the part of configurable product");
		$I->createEntity("createConfigFirstChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeFirstOption"], []); // stepKey: createConfigFirstChildProduct
		$I->createEntity("createConfigSecondChildProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeSecondOption"], []); // stepKey: createConfigSecondChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeFirstOption", "getConfigAttributeSecondOption"], []); // stepKey: createConfigProductOption
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
		$I->comment("Delete simple product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete configurable product creation");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigFirstChildProduct", "hook"); // stepKey: deleteConfigFirstChildProduct
		$I->deleteEntity("createConfigSecondChildProduct", "hook"); // stepKey: deleteConfigSecondChildProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	public function AdminExportSimpleProductAssignedToMainWebsiteAndConfigurableProductAssignedToCustomWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Go to export page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: goToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportIndexPageLoad
		$I->comment("Export created below products");
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
		$I->comment("Start message queue for export consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start exportProcessor --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->reloadPage(); // stepKey: refreshPage
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
		$I->comment("Download product");
		$I->comment("Entering Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadCreatedProductsWaitForPageLoad
		$I->comment("Exiting Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->comment("Delete exported file");
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
	}
}
