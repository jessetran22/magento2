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
 * @Title("MC-14211: Move first Configurable Product with selected optional from Category Page to Wishlist.")
 * @Description("Move first Configurable Product with selected optional from Category Page to Wishlist. On Page will be present minimum two Configurable Product<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontCheckOptionsConfigurableProductInWishlistTest.xml<br>")
 * @TestCaseId("MC-14211")
 * @group wishlist
 */
class StorefrontCheckOptionsConfigurableProductInWishlistTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createFirstConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createFirstConfigProduct
		$I->createEntity("createSecondConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createSecondConfigProduct
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
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
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [deleteFirstProducts] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteFirstProducts
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteFirstProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteFirstProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteFirstProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstConfigProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteFirstProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteFirstProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteFirstProductsWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstConfigProduct', 'sku', 'hook'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteFirstProducts
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteFirstProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteFirstProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteFirstProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteFirstProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteFirstProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteFirstProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteFirstProducts
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteFirstProductsWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteFirstProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteFirstProductsWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstProducts
		$I->comment("Exiting Action Group [deleteFirstProducts] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteSecondProducts] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSecondProducts
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSecondProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSecondProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSecondProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSecondConfigProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteSecondProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSecondProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSecondProductsWaitForPageLoad
		$I->see($I->retrieveEntityField('createSecondConfigProduct', 'sku', 'hook'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSecondProducts
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSecondProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSecondProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSecondProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSecondProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSecondProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSecondProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteSecondProducts
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteSecondProductsWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteSecondProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSecondProductsWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondProducts
		$I->comment("Exiting Action Group [deleteSecondProducts] DeleteProductBySkuActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: setAttributeLabelFilterDeleteAttribute
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"Wishlist"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Wishlist"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckOptionsConfigurableProductInWishlistTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToFirstConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createFirstConfigProduct', 'id', 'test')); // stepKey: goToProductNavigateToFirstConfigProductPage
		$I->comment("Exiting Action Group [navigateToFirstConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFirstProductPageLoad
		$I->comment("Entering Action Group [addSwatchToFirstProduct] AddVisualSwatchToProductWithStorefrontConfigActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: seeOnProductEditPageAddSwatchToFirstProduct
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSectionAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionAddSwatchToFirstProductWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPanelAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationPanelAddSwatchToFirstProductWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForSlideOutAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutAddSwatchToFirstProductWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickCreateNewAttributeAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeAddSwatchToFirstProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameAddSwatchToFirstProduct
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameAddSwatchToFirstProduct
		$I->fillField("input[name='frontend_label[0]']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillDefaultLabelAddSwatchToFirstProduct
		$I->selectOption("select[name='frontend_input']", "Visual Swatch"); // stepKey: selectInputTypeAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: selectInputTypeAddSwatchToFirstProductWaitForPageLoad
		$I->comment("Add swatch options");
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch1AddSwatchToFirstProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", 30); // stepKey: waitForOption1RowAddSwatchToFirstProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][0]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillAdminLabel1AddSwatchToFirstProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_0][1]']", "VisualOpt1" . msq("visualSwatchOption1")); // stepKey: fillDefaultStoreLabel1AddSwatchToFirstProduct
		$I->click("button#add_new_swatch_visual_option_button"); // stepKey: clickAddSwatch2AddSwatchToFirstProduct
		$I->waitForElementVisible("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", 30); // stepKey: waitForOption2RowAddSwatchToFirstProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][0]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillAdminLabel2AddSwatchToFirstProduct
		$I->fillField("[data-role='swatch-visual-options-container'] input[name='optionvisual[value][option_1][1]']", "VisualOpt2" . msq("visualSwatchOption2")); // stepKey: fillDefaultStoreLabel2AddSwatchToFirstProduct
		$I->click("#front_fieldset-wrapper"); // stepKey: goToStorefrontPropertiesTabAddSwatchToFirstProduct
		$I->waitForElementVisible("//span[text()='Storefront Properties']", 30); // stepKey: waitTabLoadAddSwatchToFirstProduct
		$I->selectOption("#is_searchable", "Yes"); // stepKey: switchOnUsInSearchAddSwatchToFirstProduct
		$I->selectOption("#is_visible_in_advanced_search", "Yes"); // stepKey: switchOnVisibleInAdvancedSearchAddSwatchToFirstProduct
		$I->selectOption("#is_comparable", "Yes"); // stepKey: switchOnComparableOnStorefrontAddSwatchToFirstProduct
		$I->selectOption("#is_filterable", "Filterable (with results)"); // stepKey: selectUseInLayerAddSwatchToFirstProduct
		$I->selectOption("#is_visible_on_front", "Yes"); // stepKey: switchOnVisibleOnCatalogPagesOnStorefrontAddSwatchToFirstProduct
		$I->selectOption("#used_in_product_listing", "Yes"); // stepKey: switchOnUsedInProductListingAddSwatchToFirstProduct
		$I->comment("Save attribute");
		$I->click("#save"); // stepKey: clickOnNewAttributePanelAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeAddSwatchToFirstProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameAddSwatchToFirstProduct
		$I->comment("Find attribute in grid and select");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersAddSwatchToFirstProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickOnFiltersAddSwatchToFirstProductWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillFilterAttributeCodeFieldAddSwatchToFirstProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAddSwatchToFirstProductWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: clickOnFirstCheckboxAddSwatchToFirstProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep1AddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep1AddSwatchToFirstProductWaitForPageLoad
		$I->click("//div[@data-attribute-title='VisualSwatchAttr" . msq("visualSwatchAttribute") . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickSelectAllAddSwatchToFirstProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep2AddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep2AddSwatchToFirstProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToFirstProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantityAddSwatchToFirstProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextStep3AddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextStep3AddSwatchToFirstProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: generateProductsAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: generateProductsAddSwatchToFirstProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAddSwatchToFirstProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupAddSwatchToFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupAddSwatchToFirstProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageAddSwatchToFirstProduct
		$I->comment("Go to Storefront Properties tab");
		$I->comment("Exiting Action Group [addSwatchToFirstProduct] AddVisualSwatchToProductWithStorefrontConfigActionGroup");
		$I->comment("Entering Action Group [navigateToSecondConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSecondConfigProduct', 'id', 'test')); // stepKey: goToProductNavigateToSecondConfigProductPage
		$I->comment("Exiting Action Group [navigateToSecondConfigProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSecondProductPageLoad
		$I->comment("Entering Action Group [addSwatchToSecondProduct] AddVisualSwatchToProductWithOutCreatedActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: seeOnProductEditPageAddSwatchToSecondProduct
		$I->conditionalClick(".admin__collapsible-block-wrapper[data-index='configurable']", "button[data-index='create_configurable_products_button']", false); // stepKey: openConfigurationSectionAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationSectionAddSwatchToSecondProductWaitForPageLoad
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: openConfigurationPanelAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: openConfigurationPanelAddSwatchToSecondProductWaitForPageLoad
		$I->waitForElementVisible(".select-attributes-actions button[title='Create New Attribute']", 30); // stepKey: waitForSlideOutAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutAddSwatchToSecondProductWaitForPageLoad
		$I->comment("Find attribute in grid and select");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersAddSwatchToSecondProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickOnFiltersAddSwatchToSecondProductWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='attribute_code']", "VisualSwatchAttr" . msq("visualSwatchAttribute")); // stepKey: fillFilterAttributeCodeFieldAddSwatchToSecondProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonAddSwatchToSecondProductWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: clickOnFirstCheckboxAddSwatchToSecondProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep1AddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep1AddSwatchToSecondProductWaitForPageLoad
		$I->click("//div[@data-attribute-title='VisualSwatchAttr" . msq("visualSwatchAttribute") . "']//button[contains(@class, 'action-select-all')]"); // stepKey: clickSelectAllAddSwatchToSecondProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickNextStep2AddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickNextStep2AddSwatchToSecondProductWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuAddSwatchToSecondProductWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "100"); // stepKey: enterAttributeQuantityAddSwatchToSecondProduct
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextStep3AddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickOnNextStep3AddSwatchToSecondProductWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: generateProductsAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: generateProductsAddSwatchToSecondProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAddSwatchToSecondProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAddSwatchToSecondProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageAddSwatchToSecondProduct
		$I->comment("Exiting Action Group [addSwatchToSecondProduct] AddVisualSwatchToProductWithOutCreatedActionGroup");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryPage
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [selectVisualSwatch] StorefrontSelectVisualSwatchOptionOnCategoryPageActionGroup");
		$I->click("#product-item-info_" . $I->retrieveEntityField('createFirstConfigProduct', 'id', 'test') . " .swatch-option[data-option-label='VisualOpt1" . msq("visualSwatchOption1") . "']"); // stepKey: clickSwatchOptionSelectVisualSwatch
		$I->comment("Exiting Action Group [selectVisualSwatch] StorefrontSelectVisualSwatchOptionOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistCategoryPageActionGroup");
		$I->click("#product-item-info_" . $I->retrieveEntityField('createFirstConfigProduct', 'id', 'test') . " .action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddToWishlistProduct
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddToWishlistProduct
		$I->see($I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddToWishlistProduct
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddToWishlistProduct
		$I->comment("Exiting Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistCategoryPageActionGroup");
		$I->seeElement("//a[contains(text(), '" . $I->retrieveEntityField('createFirstConfigProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]"); // stepKey: seeDetails
	}
}
