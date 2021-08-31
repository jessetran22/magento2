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
 * @Title("MC-3077: Admin can create product attribute with image swatch")
 * @Description("Admin can create product attribute with image swatch<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminCreateImageSwatchTest.xml<br>")
 * @TestCaseId("MC-3077")
 * @group Swatches
 */
class AdminCreateImageSwatchTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
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
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductWaitForPageLoad
		$I->see("configurable" . msq("BaseConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteConfigurableProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteConfigurableProduct
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteProductAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteProductAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: setAttributeLabelFilterDeleteProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteProductAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteProductAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteProductAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteProductAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteProductAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteProductAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteProductAttribute
		$I->comment("Exiting Action Group [deleteProductAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->comment("Entering Action Group [resetProductAttributeFilters] NavigateToAndResetProductAttributeGridToDefaultViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridResetProductAttributeFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadResetProductAttributeFilters
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductAttributeFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductAttributeFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadResetProductAttributeFilters
		$I->comment("Exiting Action Group [resetProductAttributeFilters] NavigateToAndResetProductAttributeGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Create/configure swatches"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateImageSwatchTest(AcceptanceTester $I)
	{
		$I->comment("Begin creating a new product attribute of type \"Image Swatch\"");
		$I->comment("Entering Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageGoToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToNewProductAttributePage
		$I->comment("Exiting Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->fillField("#attribute_label", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillDefaultLabel
		$I->comment("Select visual swatch");
		$I->selectOption("#frontend_input", "swatch_visual"); // stepKey: selectInputType
		$I->comment("This hack is because the same <input type=\"file\"> is re-purposed used for all uploads.");
		$disableClick = $I->executeJS("HTMLInputElement.prototype.click = function() { if(this.type !== 'file') HTMLElement.prototype.click.call(this); };"); // stepKey: disableClick
		$I->comment("Set swatch image #1");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch1WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch1 = $I->executeJS("jQuery('#swatch_window_option_option_0').click()"); // stepKey: clickSwatch1ClickSwatch1
		$I->comment("Exiting Action Group [clickSwatch1] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile1
		$I->attachFile("input[name='datafile']", "adobe-thumb.jpg"); // stepKey: attachFile1
		$I->fillField("optionvisual[value][option_0][0]", "adobe-thumb"); // stepKey: fillAdmin1
		$I->click("#swatch_window_option_option_0"); // stepKey: clicksWatchWindow1
		$I->comment("Set swatch image #2");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch2WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch2 = $I->executeJS("jQuery('#swatch_window_option_option_1').click()"); // stepKey: clickSwatch1ClickSwatch2
		$I->comment("Exiting Action Group [clickSwatch2] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile2
		$I->attachFile("input[name='datafile']", "adobe-small.jpg"); // stepKey: attachFile2
		$I->fillField("optionvisual[value][option_1][0]", "adobe-small"); // stepKey: fillAdmin2
		$I->click("#swatch_window_option_option_1"); // stepKey: clicksWatchWindow2
		$I->comment("Set swatch image #3");
		$I->click("#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch3
		$I->waitForPageLoad(30); // stepKey: clickAddSwatch3WaitForPageLoad
		$I->comment("Entering Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->comment("I had to use executeJS to perform the click to get around the use of CSS ::before and ::after");
		$clickSwatch1ClickSwatch3 = $I->executeJS("jQuery('#swatch_window_option_option_2').click()"); // stepKey: clickSwatch1ClickSwatch3
		$I->comment("Exiting Action Group [clickSwatch3] OpenSwatchMenuByIndexActionGroup");
		$I->click("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatch_row_name.btn_choose_file_upload"); // stepKey: clickUploadFile3
		$I->attachFile("input[name='datafile']", "adobe-base.jpg"); // stepKey: attachFile3
		$I->fillField("optionvisual[value][option_2][0]", "adobe-base"); // stepKey: fillAdmin3
		$I->comment("Set scope");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedProperties
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScope
		$I->scrollToTopOfPage(); // stepKey: scrollToTabs
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTab
		$I->waitForElementVisible("#used_in_product_listing", 30); // stepKey: waitForTabSwitch
		$I->selectOption("#used_in_product_listing", "Yes"); // stepKey: useInProductListing
		$I->comment("Save the new product attribute");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEdit1WaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccess
		$I->comment("Verify after round trip to the server");
		$grabSwatch1 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(1) .swatch_window", "style"); // stepKey: grabSwatch1
		$I->assertStringContainsString("adobe-thumb", $grabSwatch1); // stepKey: assertSwatch1
		$grabSwatch2 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(2) .swatch_window", "style"); // stepKey: grabSwatch2
		$I->assertStringContainsString("adobe-small", $grabSwatch2); // stepKey: assertSwatch2
		$grabSwatch3 = $I->grabAttributeFrom("#swatch-visual-options-panel table tbody tr:nth-of-type(3) .swatch_window", "style"); // stepKey: grabSwatch3
		$I->assertStringContainsString("adobe-base", $grabSwatch3); // stepKey: assertSwatch3
		$I->comment("Create a configurable product to verify the storefront with");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: goToCreateConfigurableProduct
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Create configurations based off the Image Swatch we created earlier");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFilters
		$I->fillField(".admin__control-text[name='attribute_code']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillFilterAttributeCodeField
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAll
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2WaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->comment("Go to the product page and see text swatch options");
		$I->amOnPage("configurable" . msq("BaseConfigurableProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Verify the storefront");
		$grabSwatch4 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(1)", "style"); // stepKey: grabSwatch4
		$I->assertStringContainsString("adobe-thumb", $grabSwatch4); // stepKey: assertSwatch4
		$grabSwatch5 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(2)", "style"); // stepKey: grabSwatch5
		$I->assertStringContainsString("adobe-small", $grabSwatch5); // stepKey: assertSwatch5
		$grabSwatch6 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(3)", "style"); // stepKey: grabSwatch6
		$I->assertStringContainsString("adobe-base", $grabSwatch6); // stepKey: assertSwatch6
		$I->comment("Go to the product listing page and see text swatch options");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPageStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductListingPage
		$I->comment("Verify the storefront");
		$grabSwatch7 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(1)", "style"); // stepKey: grabSwatch7
		$I->assertStringContainsString("adobe-thumb", $grabSwatch7); // stepKey: assertSwatch7
		$grabSwatch8 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(2)", "style"); // stepKey: grabSwatch8
		$I->assertStringContainsString("adobe-small", $grabSwatch8); // stepKey: assertSwatch8
		$grabSwatch9 = $I->grabAttributeFrom("div.swatch-option:nth-of-type(3)", "style"); // stepKey: grabSwatch9
		$I->assertStringContainsString("adobe-base", $grabSwatch9); // stepKey: assertSwatch9
	}
}
