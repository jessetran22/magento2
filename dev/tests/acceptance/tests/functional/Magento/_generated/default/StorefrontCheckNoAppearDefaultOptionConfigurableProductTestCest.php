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
 * @Title("MC-35074: Check for Configurable Product the default option doesn't appear.")
 * @Description("Check for Configurable Product the default option doesn't appear on the list options product when an option use.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCheckNoAppearDefaultOptionConfigurableProductTest.xml<br>")
 * @TestCaseId("MC-35074")
 */
class StorefrontCheckNoAppearDefaultOptionConfigurableProductTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "Color" . msq("colorProductAttribute")); // stepKey: setAttributeLabelFilterDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
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
	 * @Stories({"Configurable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckNoAppearDefaultOptionConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [fillBasicValue] AdminFillBasicValueConfigurableProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageFillBasicValue
		$I->waitForPageLoad(30); // stepKey: wait1FillBasicValue
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleFillBasicValue
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleFillBasicValueWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductFillBasicValue
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductFillBasicValueWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameFillBasicValue
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUFillBasicValue
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceFillBasicValue
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityFillBasicValue
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategoryFillBasicValue
		$I->waitForPageLoad(30); // stepKey: fillCategoryFillBasicValueWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityFillBasicValue
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionFillBasicValue
		$I->waitForPageLoad(30); // stepKey: openSeoSectionFillBasicValueWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyFillBasicValue
		$I->comment("Exiting Action Group [fillBasicValue] AdminFillBasicValueConfigurableProductActionGroup");
		$I->comment("Entering Action Group [createOptions] AdminAddOptionsToAttributeWithDefaultLayeredNavigationActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsCreateOptionsWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeCreateOptions
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeCreateOptionsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameCreateOptions
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameCreateOptions
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelCreateOptions
		$I->comment("Add option 1 to attribute");
		$I->click("#add_new_option_button"); // stepKey: clickAddOption1CreateOptions
		$I->waitForElementVisible("[data-role='options-container'] tr:nth-of-type(1) input[name='default[]']", 30); // stepKey: waitForOptionRow1CreateOptions
		$I->fillField("[data-role='options-container'] input[name='option[value][option_0][0]']", "White" . msq("colorProductAttribute1")); // stepKey: fillAdminLabel1CreateOptions
		$I->click("[data-role='options-container'] tr:nth-of-type(1) input[name='default[]']"); // stepKey: selectDefaultCreateOptions
		$I->click("#add_new_option_button"); // stepKey: clickAddOption2CreateOptions
		$I->waitForElementVisible("[data-role='options-container'] tr:nth-of-type(2) input[name='default[]']", 30); // stepKey: waitForOptionRow2CreateOptions
		$I->fillField("[data-role='options-container'] input[name='option[value][option_1][0]']", "Red" . msq("colorProductAttribute2")); // stepKey: fillAdminLabel2CreateOptions
		$I->click("#add_new_option_button"); // stepKey: clickAddOption3CreateOptions
		$I->waitForElementVisible("[data-role='options-container'] tr:nth-of-type(3) input[name='default[]']", 30); // stepKey: waitForOptionRow3CreateOptions
		$I->fillField("[data-role='options-container'] input[name='option[value][option_2][0]']", "Blue" . msq("colorProductAttribute3")); // stepKey: fillAdminLabel3CreateOptions
		$I->click("#front_fieldset-wrapper"); // stepKey: goToStorefrontPropertiesTabCreateOptions
		$I->waitForElementVisible("//span[text()='Storefront Properties']", 30); // stepKey: waitTabLoadCreateOptions
		$I->selectOption("#is_filterable", "Filterable (with results)"); // stepKey: selectUseInLayerCreateOptions
		$I->comment("Add option 2 to attribute");
		$I->comment("Add option 3 to attribute");
		$I->comment("Set Use In Layered Navigation");
		$I->comment("Save attribute");
		$I->click("#save"); // stepKey: clickSaveAttributeCreateOptions
		$I->waitForPageLoad(30); // stepKey: waitForSavingAttributeCreateOptions
		$I->comment("Exiting Action Group [createOptions] AdminAddOptionsToAttributeWithDefaultLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [gotoSelectValuePage] AdminGotoSelectValueAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersGotoSelectValuePage
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldGotoSelectValuePage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonGotoSelectValuePage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonGotoSelectValuePageWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxGotoSelectValuePage
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButtonGotoSelectValuePage
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonGotoSelectValuePageWaitForPageLoad
		$I->comment("Exiting Action Group [gotoSelectValuePage] AdminGotoSelectValueAttributePageActionGroup");
		$I->comment("Entering Action Group [selectColorProductAttribute2] AdminSelectValueFromAttributeActionGroup");
		$I->click("li[data-attribute-option-title='Red" . msq("colorProductAttribute2") . "']"); // stepKey: clickOnCreateNewValue2SelectColorProductAttribute2
		$I->comment("Exiting Action Group [selectColorProductAttribute2] AdminSelectValueFromAttributeActionGroup");
		$I->comment("Entering Action Group [selectColorProductAttribute3] AdminSelectValueFromAttributeActionGroup");
		$I->click("li[data-attribute-option-title='Blue" . msq("colorProductAttribute3") . "']"); // stepKey: clickOnCreateNewValue2SelectColorProductAttribute3
		$I->comment("Exiting Action Group [selectColorProductAttribute3] AdminSelectValueFromAttributeActionGroup");
		$I->comment("Entering Action Group [saveConfigurable] AdminSetQuantityToEachSkusConfigurableProductActionGroup");
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2SaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2SaveConfigurableWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuSaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuSaveConfigurableWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantitySaveConfigurable
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3SaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3SaveConfigurableWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4SaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4SaveConfigurableWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2SaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2SaveConfigurableWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupSaveConfigurable
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupSaveConfigurableWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageSaveConfigurable
		$I->comment("Exiting Action Group [saveConfigurable] AdminSetQuantityToEachSkusConfigurableProductActionGroup");
		$grabSkuProduct = $I->grabValueFrom("//input[@name='product[sku]']"); // stepKey: grabSkuProduct
		$I->comment("Adding the comment to replace 'indexer:reindex' command for preserving Backward Compatibility");
		$I->comment("Entering Action Group [expandOption] SelectStorefrontSideBarAttributeOption");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: openCategoryStoreFrontPageExpandOption
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadExpandOption
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCategoryInFrontPageExpandOption
		$I->waitForPageLoad(30); // stepKey: seeCategoryInFrontPageExpandOptionWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: clickOnCategoryExpandOption
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryExpandOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad1ExpandOption
		$I->seeElement("//div[@class='filter-options-title' and contains(text(), 'Color" . msq("colorProductAttribute") . "')]"); // stepKey: seeAttributeOptionsTitleExpandOption
		$I->click("//div[@class='filter-options-title' and contains(text(), 'Color" . msq("colorProductAttribute") . "')]"); // stepKey: clickAttributeOptionsExpandOption
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadExpandOption
		$I->comment("Exiting Action Group [expandOption] SelectStorefrontSideBarAttributeOption");
		$I->dontSeeElement("//div[contains(text(), 'Color" . msq("colorProductAttribute") . "')]//following-sibling::div//a[contains(text(), 'White" . msq("colorProductAttribute1") . "')]"); // stepKey: dontSeeCaptchaField
		$I->comment("Entering Action Group [deleteConfigurableProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "$grabSkuProduct"); // stepKey: fillProductSkuFilterDeleteConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductWaitForPageLoad
		$I->see("$grabSkuProduct", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProduct
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
	}
}
