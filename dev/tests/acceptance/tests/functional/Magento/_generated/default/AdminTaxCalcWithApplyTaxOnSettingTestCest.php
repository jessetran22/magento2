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
 * @Title("MC-11026: Tax calculation process following 'Apply Tax On' setting")
 * @Description("Tax calculation process following 'Apply Tax On' setting<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminTaxCalcWithApplyTaxOnSettingTest.xml<br>")
 * @TestCaseId("MC-11026")
 * @group Tax
 */
class AdminTaxCalcWithApplyTaxOnSettingTestCest
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
		$I->createEntity("initialTaxRate", "hook", "taxRateForPensylvannia", [], []); // stepKey: initialTaxRate
		$I->createEntity("createTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: createTaxRule
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProductWithCustomPrice", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [setTaxClass] SetTaxClassForShippingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: navigateToSalesTaxPageSetTaxClass
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetTaxClass
		$I->conditionalClick("#tax_classes-head", "#tax_classes-head:not(.open)", true); // stepKey: expandTaxClassesTabSetTaxClass
		$I->waitForElementVisible("#tax_classes_shipping_tax_class", 30); // stepKey: seeShippingTaxClassSetTaxClass
		$I->uncheckOption("#tax_classes_shipping_tax_class_inherit"); // stepKey: uncheckUseSystemValueSetTaxClass
		$I->selectOption("#tax_classes_shipping_tax_class", "Taxable Goods"); // stepKey: setShippingTaxClassSetTaxClass
		$I->click("#tax_classes-head"); // stepKey: collapseTaxClassesTabSetTaxClass
		$I->click("#save"); // stepKey: saveConfigSetTaxClass
		$I->waitForPageLoad(30); // stepKey: saveConfigSetTaxClassWaitForPageLoad
		$I->comment("Exiting Action Group [setTaxClass] SetTaxClassForShippingActionGroup");
		$I->comment("Entering Action Group [setApplyTaxOnSetting] SetTaxApplyOnSettingActionGroup");
		$I->conditionalClick("#tax_calculation-head", "#tax_calculation_algorithm", false); // stepKey: openTaxCalcSettingsSectionSetApplyTaxOnSetting
		$I->scrollTo("#tax_calculation_apply_tax_on_inherit", 0, -80); // stepKey: goToCheckboxSetApplyTaxOnSetting
		$I->uncheckOption("#tax_calculation_apply_tax_on_inherit"); // stepKey: enableApplyTaxOnSettingSetApplyTaxOnSetting
		$I->selectOption("#tax_calculation_apply_tax_on", "Original price only"); // stepKey: setApplyTaxOnSetApplyTaxOnSetting
		$I->scrollTo("#tax_classes-head"); // stepKey: scrollToTopSetApplyTaxOnSetting
		$I->click("#tax_calculation-head"); // stepKey: collapseCalcSettingsTabSetApplyTaxOnSetting
		$I->waitForPageLoad(30); // stepKey: collapseCalcSettingsTabSetApplyTaxOnSettingWaitForPageLoad
		$I->click("#save"); // stepKey: saveConfigSetApplyTaxOnSetting
		$I->waitForPageLoad(30); // stepKey: waitForConfigSavedSetApplyTaxOnSetting
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSetApplyTaxOnSetting
		$I->comment("Exiting Action Group [setApplyTaxOnSetting] SetTaxApplyOnSettingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/edit/rule/" . $I->retrieveEntityField('createTaxRule', 'id', 'hook') . "/"); // stepKey: navigateToEditTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitEditTaxRulePageToLoad
		$I->click("//div[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//div[@class='mselect-items-wrapper']//label[1]"); // stepKey: clickonTaxRate
		$I->click("//span[contains(text(),'" . $I->retrieveEntityField('initialTaxRate', 'code', 'hook') . "')]"); // stepKey: checkTaxRate
		$I->click("#save"); // stepKey: saveChanges
		$I->waitForPageLoad(30); // stepKey: saveChangesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitTaxRulesToBeSaved
		$I->see("You saved the tax rule.", "#messages div.message-success"); // stepKey: seeSuccessMessage2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->deleteEntity("initialTaxRate", "hook"); // stepKey: deleteTaxRate
		$I->comment("Entering Action Group [setApplyTaxOffSetting] DisableTaxApplyOnOriginalPriceActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: navigateToSalesTaxPageSetApplyTaxOffSetting
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetApplyTaxOffSetting
		$I->conditionalClick("#tax_calculation-head", "#tax_calculation_algorithm", false); // stepKey: openTaxCalcSettingsSectionSetApplyTaxOffSetting
		$I->scrollTo("#tax_calculation_apply_tax_on_inherit", 0, -80); // stepKey: goToCheckboxSetApplyTaxOffSetting
		$I->selectOption("#tax_calculation_apply_tax_on", "Custom price if available"); // stepKey: setApplyTaxOffSetApplyTaxOffSetting
		$I->checkOption("#tax_calculation_apply_tax_on_inherit"); // stepKey: disableApplyTaxOnSettingSetApplyTaxOffSetting
		$I->click("#save"); // stepKey: saveConfigSetApplyTaxOffSetting
		$I->waitForPageLoad(30); // stepKey: waitForConfigSavedSetApplyTaxOffSetting
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSetApplyTaxOffSetting
		$I->comment("Exiting Action Group [setApplyTaxOffSetting] DisableTaxApplyOnOriginalPriceActionGroup");
		$I->comment("Entering Action Group [resetTaxClassForShipping] ResetTaxClassForShippingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: navigateToSalesTaxConfigPagetoResetResetTaxClassForShipping
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetTaxClassForShipping
		$I->conditionalClick("#tax_classes-head", "#tax_classes-head:not(.open)", true); // stepKey: openTaxClassTabResetTaxClassForShipping
		$I->waitForElementVisible("#tax_classes_shipping_tax_class", 30); // stepKey: seeShippingTaxClass2ResetTaxClassForShipping
		$I->selectOption("#tax_classes_shipping_tax_class", "None"); // stepKey: resetShippingTaxClassResetTaxClassForShipping
		$I->checkOption("#tax_classes_shipping_tax_class_inherit"); // stepKey: useSystemValueResetTaxClassForShipping
		$I->click("#tax_classes-head"); // stepKey: collapseTaxClassesTabResetTaxClassForShipping
		$I->click("#save"); // stepKey: saveConfigurationResetTaxClassForShipping
		$I->waitForPageLoad(30); // stepKey: saveConfigurationResetTaxClassForShippingWaitForPageLoad
		$I->comment("Exiting Action Group [resetTaxClassForShipping] ResetTaxClassForShippingActionGroup");
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
	 * @Features({"Tax"})
	 * @Stories({"Tax calculation"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminTaxCalcWithApplyTaxOnSettingTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [gotoNewOrderCreationPage] NavigateToNewOrderPageNewCustomerSingleStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageGotoNewOrderCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadGotoNewOrderCreationPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleGotoNewOrderCreationPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderGotoNewOrderCreationPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderGotoNewOrderCreationPageWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerGotoNewOrderCreationPage
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerGotoNewOrderCreationPageWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsGotoNewOrderCreationPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsGotoNewOrderCreationPageWaitForPageLoad
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleGotoNewOrderCreationPage
		$I->comment("Exiting Action Group [gotoNewOrderCreationPage] NavigateToNewOrderPageNewCustomerSingleStoreActionGroup");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->fillField("#email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailField
		$I->comment("Entering Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", "John"); // stepKey: fillFirstNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", "Doe"); // stepKey: fillLastNameFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Los Angeles"); // stepKey: fillCityFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerAddressWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "California"); // stepKey: fillStateFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "90001"); // stepKey: fillPostalCodeFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerAddressWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerAddress
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerAddressWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerAddress] FillOrderCustomerInformationActionGroup");
		$I->scrollTo("#email"); // stepKey: scrollToEmailField
		$I->waitForElementVisible("#email", 30); // stepKey: waitEmailFieldToBeVisible
		$I->click("#order-shipping_same_as_billing"); // stepKey: uncheckSameAsBillingAddressCheckbox
		$I->waitForPageLoad(30); // stepKey: waitSectionToReload
		$I->selectOption("#order-shipping_address_region_id", "Pennsylvania"); // stepKey: switchOnVisibleInAdvancedSearch
		$I->click("#order-shipping_method a.action-default"); // stepKey: getShippingMethods
		$I->waitForPageLoad(30); // stepKey: getShippingMethodsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyingShippingMethods
		$grabTaxCost = $I->grabTextFrom("#order-totals>table tr.row-totals:nth-of-type(3) span.price"); // stepKey: grabTaxCost
		$I->assertEquals("$6.00", ($grabTaxCost)); // stepKey: assertTax
		$I->scrollTo("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: scrollToSubmitButton
		$I->waitForPageLoad(30); // stepKey: scrollToSubmitButtonWaitForPageLoad
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitElementToBeVisble
		$I->waitForPageLoad(30); // stepKey: waitElementToBeVisbleWaitForPageLoad
		$I->click("//*[@class='custom-price-block']/input"); // stepKey: clickOnCustomPriceCheckbox
		$I->fillField("//*[@class='custom-price-block']/following-sibling::input", "10.00"); // stepKey: changePrice
		$I->click("//span[contains(text(),'Update Items and Quantities')]"); // stepKey: updateItemsAndQunatities
		$I->assertEquals("$6.00", ($grabTaxCost)); // stepKey: assertTaxAfterCustomPrice
	}
}
