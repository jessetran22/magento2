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
 * @Title("MC-16471: Import customizable options to a product with existing SKU")
 * @Description("Import customizable options to a product with existing SKU<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminImportCustomizableOptionToProductWithSKUTest.xml<br>")
 * @TestCaseId("MC-16471")
 * @group catalog
 */
class AdminImportCustomizableOptionToProductWithSKUTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create two products");
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstProduct
		$I->updateEntity("createFirstProduct", "hook", "ProductWithTwoTextFieldOptions",["createFirstProduct"]); // stepKey: updateFirstProductWithCustomOptions
		$I->createEntity("createSecondProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSecondProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->comment("Delete second product with changed sku");
		$I->comment("Entering Action Group [deleteSecondProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSecondProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSecondProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSecondProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstProduct', 'sku', 'hook') . "-1"); // stepKey: fillProductSkuFilterDeleteSecondProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSecondProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstProduct', 'sku', 'hook') . "-1", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSecondProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSecondProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSecondProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSecondProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSecondProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteSecondProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteSecondProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteSecondProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSecondProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondProduct
		$I->comment("Exiting Action Group [deleteSecondProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [clearProductGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Customizable options"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportCustomizableOptionToProductWithSKUTest(AcceptanceTester $I)
	{
		$I->comment("Change second product sku to first product sku");
		$I->comment("Entering Action Group [goToProductEditPage1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSecondProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage1
		$I->comment("Exiting Action Group [goToProductEditPage1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoad1
		$I->fillField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createFirstProduct', 'sku', 'test')); // stepKey: fillProductSku1
		$I->comment("Import customizable options and check");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSection
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionWaitForPageLoad
		$I->comment("Entering Action Group [importOptions] ImportProductCustomizableOptionsActionGroup");
		$I->click("//button[@data-index='button_import']"); // stepKey: clickImportOptionsImportOptions
		$I->waitForPageLoad(30); // stepKey: clickImportOptionsImportOptionsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'product_form_product_form_import_options_modal')]//h1[contains(text(), 'Select Product')]", 30); // stepKey: waitForTitleVisibleImportOptions
		$I->waitForPageLoad(30); // stepKey: waitForTitleVisibleImportOptionsWaitForPageLoad
		$I->conditionalClick("aside.product_form_product_form_import_options_modal button[data-action='grid-filter-reset']", "aside.product_form_product_form_import_options_modal button[data-action='grid-filter-reset']", true); // stepKey: clickResetFiltersImportOptions
		$I->waitForPageLoad(30); // stepKey: clickResetFiltersImportOptionsWaitForPageLoad
		$I->click("aside.product_form_product_form_import_options_modal button[data-action='grid-filter-expand']"); // stepKey: clickFilterButtonImportOptions
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonImportOptionsWaitForPageLoad
		$I->waitForElementVisible("aside.product_form_product_form_import_options_modal input[name='name']", 30); // stepKey: waitForNameFieldImportOptions
		$I->waitForPageLoad(30); // stepKey: waitForNameFieldImportOptionsWaitForPageLoad
		$I->fillField("aside.product_form_product_form_import_options_modal input[name='name']", $I->retrieveEntityField('createFirstProduct', 'name', 'test')); // stepKey: fillProductNameImportOptions
		$I->waitForPageLoad(30); // stepKey: fillProductNameImportOptionsWaitForPageLoad
		$I->click("aside.product_form_product_form_import_options_modal button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersImportOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersImportOptionsWaitForPageLoad
		$I->checkOption("aside.product_form_product_form_import_options_modal input[data-action='select-row']"); // stepKey: checkProductCheckboxImportOptions
		$I->waitForPageLoad(30); // stepKey: checkProductCheckboxImportOptionsWaitForPageLoad
		$I->click("//aside[contains(@class, 'product_form_product_form_import_options_modal')]//button[contains(@class, 'action-primary')]/span[contains(text(), 'Import')]"); // stepKey: clickImportImportOptions
		$I->waitForPageLoad(30); // stepKey: clickImportImportOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [importOptions] ImportProductCustomizableOptionsActionGroup");
		$I->comment("Entering Action Group [checkFirstOptionImport] CheckCustomizableOptionImportActionGroup");
		$grabOptionTitleCheckFirstOptionImport = $I->grabValueFrom("input[name='product[options][0][title]']"); // stepKey: grabOptionTitleCheckFirstOptionImport
		$grabOptionPriceCheckFirstOptionImport = $I->grabValueFrom("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][price]']"); // stepKey: grabOptionPriceCheckFirstOptionImport
		$grabOptionSkuCheckFirstOptionImport = $I->grabValueFrom("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][sku]']"); // stepKey: grabOptionSkuCheckFirstOptionImport
		$I->assertEquals("OptionField", $grabOptionTitleCheckFirstOptionImport); // stepKey: assertOptionTitleCheckFirstOptionImport
		$I->assertEquals("10.000000", $grabOptionPriceCheckFirstOptionImport); // stepKey: assertOptionPriceCheckFirstOptionImport
		$I->assertEquals("OptionField", $grabOptionSkuCheckFirstOptionImport); // stepKey: assertOptionSkuCheckFirstOptionImport
		$I->comment("Exiting Action Group [checkFirstOptionImport] CheckCustomizableOptionImportActionGroup");
		$I->comment("Entering Action Group [checkSecondOptionImport] CheckCustomizableOptionImportActionGroup");
		$grabOptionTitleCheckSecondOptionImport = $I->grabValueFrom("input[name='product[options][1][title]']"); // stepKey: grabOptionTitleCheckSecondOptionImport
		$grabOptionPriceCheckSecondOptionImport = $I->grabValueFrom("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][price]']"); // stepKey: grabOptionPriceCheckSecondOptionImport
		$grabOptionSkuCheckSecondOptionImport = $I->grabValueFrom("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][sku]']"); // stepKey: grabOptionSkuCheckSecondOptionImport
		$I->assertEquals("OptionField2", $grabOptionTitleCheckSecondOptionImport); // stepKey: assertOptionTitleCheckSecondOptionImport
		$I->assertEquals("20.000000", $grabOptionPriceCheckSecondOptionImport); // stepKey: assertOptionPriceCheckSecondOptionImport
		$I->assertEquals("OptionField2", $grabOptionSkuCheckSecondOptionImport); // stepKey: assertOptionSkuCheckSecondOptionImport
		$I->comment("Exiting Action Group [checkSecondOptionImport] CheckCustomizableOptionImportActionGroup");
		$I->comment("Save product and check sku changed message");
		$I->comment("Entering Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondProduct
		$I->comment("Exiting Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->see("SKU for product " . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . " has been changed to " . $I->retrieveEntityField('createFirstProduct', 'sku', 'test') . "-1.", ".message.message-notice.notice"); // stepKey: seeSkuChangedMessage
	}
}
