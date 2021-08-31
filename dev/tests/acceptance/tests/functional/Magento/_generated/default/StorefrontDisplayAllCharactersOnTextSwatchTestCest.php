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
 * @Title("MC-5975: Admin can create product attribute with text swatch and view the display characters  in full")
 * @Description("Admin can create product attribute with text swatch and check the display characters in full<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontDisplayAllCharactersOnTextSwatchTest.xml<br>")
 * @TestCaseId("MC-5975")
 * @group Swatches
 */
class StorefrontDisplayAllCharactersOnTextSwatchTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Create/configure swatches and check the display characters length"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDisplayAllCharactersOnTextSwatchTest(AcceptanceTester $I)
	{
		$I->comment("Begin creating a new product attribute");
		$I->comment("Entering Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageGoToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToNewProductAttributePage
		$I->comment("Exiting Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->fillField("#attribute_label", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillDefaultLabel
		$I->comment("Select text swatch");
		$I->selectOption("#frontend_input", "swatch_text"); // stepKey: selectInputType
		$I->comment("Create swatch #1");
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch0
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "red"); // stepKey: fillSwatch0
		$I->fillField("input[name='optiontext[value][option_0][0]']", "Something red."); // stepKey: fillDescription0
		$I->comment("Create swatch #2");
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "blue"); // stepKey: fillSwatch1
		$I->fillField("input[name='optiontext[value][option_1][0]']", "Something blue."); // stepKey: fillDescription1
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "1234567890123456789012341234"); // stepKey: fillSwatch2
		$I->fillField("input[name='optiontext[value][option_2][0]']", "1234567890123456789012341234GreenD"); // stepKey: fillDescription2
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch3
		$I->fillField("input[name='swatchtext[value][option_3][0]']", "123456789012345678901"); // stepKey: fillSwatch3
		$I->fillField("input[name='optiontext[value][option_3][0]']", "123456789012345678901BrownD"); // stepKey: fillDescription3
		$I->comment("Set scope to global");
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedProperties
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScope
		$I->comment("Set Use In Layered Navigation");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop1
		$I->click("#product_attribute_tabs_front"); // stepKey: goToStorefrontProperties
		$I->selectOption("#is_filterable", "1"); // stepKey: selectUseInLayeredNavigation
		$I->comment("Workaround: click on the main tab again to ensure the values are saved, otherwise the swatches do not get saved");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop2
		$I->click("#product_attribute_tabs_main"); // stepKey: goBackToPropertiesTab
		$I->comment("Save the new attribute");
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAndEdit1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndEdit1WaitForPageLoad
		$I->waitForElementVisible(".message.message-success.success", 30); // stepKey: waitForSuccess
		$I->comment("Create a configurable product to verify the storefront with");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownGoToCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlGoToCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateConfigurableProduct
		$I->comment("Exiting Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
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
		$I->comment("Create configurations based off the text swatch we created earlier");
		$I->comment("Entering Action Group [createConfigurations] CreateConfigurationsForAttributeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillFilterAttributeCodeFieldCreateConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateConfigurationsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2CreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2CreateConfigurationsWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupCreateConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [createConfigurations] CreateConfigurationsForAttributeActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Go to the category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage
		$I->comment("Verify swatches are present in the layered navigation");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#layered-filter-block"); // stepKey: seeAttributeInLayeredNav
		$I->click("//div[@class='filter-options-title'][text() = 'attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: expandAttribute
		$I->waitForPageLoad(30); // stepKey: expandAttributeWaitForPageLoad
		$I->see("red", "div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(1) div"); // stepKey: seeRed
		$I->waitForPageLoad(30); // stepKey: seeRedWaitForPageLoad
		$I->see("blue", "div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(2) div"); // stepKey: seeBlue
		$I->waitForPageLoad(30); // stepKey: seeBlueWaitForPageLoad
		$I->see("123456789012345678901", "div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(3) div"); // stepKey: seeGreen
		$I->waitForPageLoad(30); // stepKey: seeGreenWaitForPageLoad
		$I->see("123456789012345678901", "div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(4) div"); // stepKey: seeBrown
		$I->waitForPageLoad(30); // stepKey: seeBrownWaitForPageLoad
		$I->comment("Click a swatch and expect to see the configurable product, not see the simple product");
		$I->click("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(1) div"); // stepKey: filterBySwatch1
		$I->waitForPageLoad(30); // stepKey: filterBySwatch1WaitForPageLoad
		$I->see("configurable" . msq("BaseConfigurableProduct"), ".product-item-info"); // stepKey: seeConfigurableProduct
		$I->dontSee($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".product-item-info"); // stepKey: dontSeeSimpleProduct
		$I->comment("Create swatch #3");
		$I->comment("Create swatch #4");
		$I->comment("Go to the category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage2
		$I->comment("Verify swatch2 is present and shown in full display text characters on storefront in the layered navigation");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#layered-filter-block"); // stepKey: seeAttributeInLayeredNav2
		$I->click("//div[@class='filter-options-title'][text() = 'attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: expandAttribute2
		$I->waitForPageLoad(30); // stepKey: expandAttribute2WaitForPageLoad
		$I->click("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(2) div"); // stepKey: filterBySwatch2
		$I->waitForPageLoad(30); // stepKey: filterBySwatch2WaitForPageLoad
		$I->comment("Go to the category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage3
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage3
		$I->comment("Verify swatch3 is present and shown in full display text characters on storefront in the layered navigation");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#layered-filter-block"); // stepKey: seeAttributeInLayeredNav3
		$I->click("//div[@class='filter-options-title'][text() = 'attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: expandAttribute3
		$I->waitForPageLoad(30); // stepKey: expandAttribute3WaitForPageLoad
		$I->click("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(3) div"); // stepKey: filterBySwatch3
		$I->waitForPageLoad(30); // stepKey: filterBySwatch3WaitForPageLoad
		$I->comment("Go to the category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage4
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPage4
		$I->comment("Verify swatch4 is present and shown in full display text characters on storefront in the layered navigation");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#layered-filter-block"); // stepKey: seeAttributeInLayeredNav4
		$I->click("//div[@class='filter-options-title'][text() = 'attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: expandAttribute4
		$I->waitForPageLoad(30); // stepKey: expandAttribute4WaitForPageLoad
		$I->click("div.attribute" . msq("ProductAttributeFrontendLabel") . " a:nth-of-type(4) div"); // stepKey: filterBySwatch4
		$I->waitForPageLoad(30); // stepKey: filterBySwatch4WaitForPageLoad
		$I->comment("Deletes the created configurable product");
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='name']", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductNameFilterDeleteConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductWaitForPageLoad
		$I->see("configurable" . msq("BaseConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteConfigurableProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteConfigurableProduct] DeleteProductUsingProductGridActionGroup");
	}
}
