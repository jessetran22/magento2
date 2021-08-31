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
 * @Title("MAGETWO-95995: Check that validator works correctly when creating Configurations for Configurable Products")
 * @Description("Verify validator works correctly for Configurable Products<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCheckValidatorConfigurableProductTest.xml<br>")
 * @TestCaseId("MAGETWO-95995")
 * @group ConfigurableProduct
 */
class AdminCheckValidatorConfigurableProductTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->comment("Entering Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "API Configurable Product" . msq("ApiConfigurableProduct") . "-thisIsShortName"); // stepKey: fillProductSkuFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("API Configurable Product" . msq("ApiConfigurableProduct") . "-thisIsShortName", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
		$I->comment("Remove attribute");
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("productDropDownAttribute")); // stepKey: setAttributeCodeDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Configurable Product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"ConfigurableProduct"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckValidatorConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Find the product that we just created using the product grid");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialWaitForPageLoad
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductFilterLoad
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Create configurations based off the Text Swatch we created earlier");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->comment("Create new attribute");
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForNewAttributePageOpened
		$I->waitForPageLoad(30); // stepKey: waitForNewAttributePageOpenedWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickCreateNewAttribute
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeWaitForPageLoad
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: enterAttributePanelIFrame
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForIframeLoad
		$I->fillField("input[name='frontend_label[0]']", "attribute" . msq("productDropDownAttribute")); // stepKey: fillDefaultLabel
		$I->selectOption("select[name='frontend_input']", "Dropdown"); // stepKey: selectAttributeInputType
		$I->waitForPageLoad(30); // stepKey: selectAttributeInputTypeWaitForPageLoad
		$I->click("#add_new_option_button"); // stepKey: clickAddOption1
		$I->waitForElementVisible("[data-role='options-container'] tr:nth-of-type(1) input[name='default[]']", 30); // stepKey: waitForOptionRow1
		$I->fillField("[data-role='options-container'] input[name='option[value][option_0][0]']", "ThisIsLongNameNameLengthMoreThanSixtyFourThisIsLongNameNameLength"); // stepKey: fillAdminLabel1
		$I->fillField("[data-role='options-container'] input[name='option[value][option_0][1]']", "White" . msq("colorProductAttribute1")); // stepKey: fillDefaultLabel1
		$I->comment("Add option to attribute");
		$I->comment("Save attribute");
		$I->click("#save"); // stepKey: clickOnNewAttributePanel
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttribute
		$I->switchToIFrame(); // stepKey: switchOutOfIFrame
		$I->comment("Find attribute in grid and select");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFilters
		$I->waitForPageLoad(30); // stepKey: clickOnFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", "attribute" . msq("productDropDownAttribute")); // stepKey: fillFilterAttributeCodeField
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: clickOnFirstCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep1
		$I->waitForPageLoad(30); // stepKey: clickNextStep1WaitForPageLoad
		$I->waitForElementVisible("//div[@data-attribute-title='attribute" . msq("productDropDownAttribute") . "']//button[contains(@class, 'action-select-all')]", 30); // stepKey: waitForNextPageOpened
		$I->click("//div[@data-attribute-title='attribute" . msq("productDropDownAttribute") . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickSelectAll
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep2
		$I->waitForPageLoad(30); // stepKey: clickNextStep2WaitForPageLoad
		$I->waitForElementVisible(".admin__field-label[for='apply-single-price-radio']", 30); // stepKey: waitForNextPageOpened2
		$I->click(".admin__field-label[for='apply-single-price-radio']"); // stepKey: clickOnApplySinglePriceToAllSkus
		$I->fillField("#apply-single-price-input", "10"); // stepKey: enterAttributePrice
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextStep3
		$I->waitForPageLoad(30); // stepKey: clickOnNextStep3WaitForPageLoad
		$I->waitForElementVisible(".steps-wizard-navigation .action-next-step", 30); // stepKey: waitForNextPageOpened3
		$I->waitForPageLoad(30); // stepKey: waitForNextPageOpened3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: generateProducts
		$I->waitForPageLoad(30); // stepKey: generateProductsWaitForPageLoad
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveButtonVisible
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonVisibleWaitForPageLoad
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitForPopUpVisible
		$I->waitForPageLoad(30); // stepKey: waitForPopUpVisibleWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->dontSeeElement("#messages div.message-success"); // stepKey: dontSeeSaveProductMessage
		$I->comment("Close modal window");
		$I->click("//*[contains(@class,'product_form_product_form_configurable_attribute_set')]//button[@data-role='closeBtn']"); // stepKey: clickOnClosePopup
		$I->waitForPageLoad(30); // stepKey: clickOnClosePopupWaitForPageLoad
		$I->waitForElementNotVisible("//*[contains(@class,'product_form_product_form_configurable_attribute_set')]//button[@data-role='closeBtn']", 30); // stepKey: waitForDialogClosed
		$I->waitForPageLoad(30); // stepKey: waitForDialogClosedWaitForPageLoad
		$I->comment("See that validation message is shown under the fields");
		$I->scrollTo(".admin__control-fields[data-index='sku_container']"); // stepKey: scrollTConfigurationTab
		$I->see("Please enter less or equal than 64 symbols.", "//*[@name='configurable-matrix[0][sku]']/following-sibling::label"); // stepKey: SeeValidationMessage
		$I->comment("Edit \"SKU\" with valid quantity");
		$I->fillField("//*[@name='configurable-matrix[0][sku]']", "API Configurable Product" . msq("ApiConfigurableProduct") . "-thisIsShortName"); // stepKey: fillValidValue
		$I->comment("Click on \"Save\"");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisible
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleWaitForPageLoad
		$I->comment("Entering Action Group [saveProductAgain] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProductAgain
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProductAgain
		$I->comment("Exiting Action Group [saveProductAgain] AdminProductFormSaveActionGroup");
		$I->comment("Click on \"Confirm\". Product is saved, success message appears");
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisible
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessage
	}
}
