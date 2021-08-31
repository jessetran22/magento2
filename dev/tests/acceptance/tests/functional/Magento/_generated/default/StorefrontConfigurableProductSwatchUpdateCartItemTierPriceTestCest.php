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
 * @Title("MC-36047: Swatch option should show the tier price on product page when Cart Item edited.")
 * @Description("Configurable product with swatch attribute should show the tier price on product page when added Cart Item.<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontConfigurableProductSwatchUpdateCartItemTierPriceTest.xml<br>")
 * @TestCaseId("MC-36047")
 * @group Swatches
 */
class StorefrontConfigurableProductSwatchUpdateCartItemTierPriceTestCest
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
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigurableProduct
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
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteColorAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteColorAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteColorAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "color_attr" . msq("ProductColorAttribute")); // stepKey: setAttributeCodeDeleteColorAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteColorAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteColorAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteColorAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteColorAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteColorAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteColorAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteColorAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteColorAttribute
		$I->comment("Exiting Action Group [deleteColorAttribute] DeleteProductAttributeActionGroup");
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
	 * @Stories({"Configurable product with swatch attribute"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductSwatchUpdateCartItemTierPriceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [addColorAttribute] AddTextSwatchToProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageAddColorAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNewProductAttributePageAddColorAttribute
		$I->fillField("#attribute_label", "Color"); // stepKey: fillDefaultLabelAddColorAttribute
		$I->selectOption("#frontend_input", "Text Swatch"); // stepKey: selectInputTypeAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "Black"); // stepKey: fillSwatch1AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_0][0]']", "Black"); // stepKey: fillSwatch1DescriptionAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "White"); // stepKey: fillSwatch2AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_1][0]']", "White"); // stepKey: fillSwatch2DescriptionAddColorAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch3AddColorAttribute
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "Blue"); // stepKey: fillSwatch3AddColorAttribute
		$I->fillField("input[name='optiontext[value][option_2][0]']", "Blue"); // stepKey: fillSwatch3DescriptionAddColorAttribute
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedPropertiesAddColorAttribute
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScopeAddColorAttribute
		$I->fillField("#attribute_code", "color_attr" . msq("ProductColorAttribute")); // stepKey: fillAttributeCodeFieldAddColorAttribute
		$I->scrollToTopOfPage(); // stepKey: scrollToTabsAddColorAttribute
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabAddColorAttribute
		$I->waitForElementVisible("#used_in_product_listing", 30); // stepKey: waitForTabSwitchAddColorAttribute
		$I->selectOption("#used_in_product_listing", "No"); // stepKey: useInProductListingAddColorAttribute
		$I->selectOption("#is_filterable", "No"); // stepKey: useInLayeredNavigationAddColorAttribute
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAddColorAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveAddColorAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [addColorAttribute] AddTextSwatchToProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigurableProduct', 'id', 'test')); // stepKey: goToConfigurableProduct
		$I->comment("Entering Action Group [createProductConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsCreateProductConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersCreateProductConfigurations
		$I->fillField(".admin__control-text[name='attribute_code']", "color_attr" . msq("ProductColorAttribute")); // stepKey: fillFilterAttributeCodeFieldCreateProductConfigurations
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonCreateProductConfigurationsWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1CreateProductConfigurationsWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2CreateProductConfigurationsWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuCreateProductConfigurationsWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityCreateProductConfigurations
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3CreateProductConfigurationsWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4CreateProductConfigurations
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4CreateProductConfigurationsWaitForPageLoad
		$I->comment("Exiting Action Group [createProductConfigurations] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveBtnVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: saveProductAgainSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: saveProductAgainSaveConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("button[data-index='confirm_button']", 30); // stepKey: waitPopUpVisibleSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitPopUpVisibleSaveConfigurableProductWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmPopupSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmPopupSaveConfigurableProductWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSaveProductMessageSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveConfigurableProductAddToCurrentAttributeSetActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigurableProduct', 'sku', 'test') . "-White"); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigurableProduct', 'sku', 'test') . "-White']]"); // stepKey: openSelectedProductFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$I->comment("Entering Action Group [addTierPriceToSimpleProduct] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonAddTierPriceToSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonAddTierPriceToSimpleProductWaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceToSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceToSimpleProductWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceToSimpleProduct
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceToSimpleProductWaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2AddTierPriceToSimpleProduct
		$I->selectOption("[name='product[tier_price][0][website_id]']", ""); // stepKey: selectProductWebsiteValueAddTierPriceToSimpleProduct
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: selectProductCustomGroupValueAddTierPriceToSimpleProduct
		$I->fillField("[name='product[tier_price][0][price_qty]']", "5"); // stepKey: fillProductTierPriceQtyInputAddTierPriceToSimpleProduct
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeAddTierPriceToSimpleProduct
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "50"); // stepKey: selectProductTierPricePriceInputAddTierPriceToSimpleProduct
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddTierPriceToSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddTierPriceToSimpleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveAddTierPriceToSimpleProduct
		$I->click("#save-button"); // stepKey: clickSaveProduct1AddTierPriceToSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1AddTierPriceToSimpleProductWaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1AddTierPriceToSimpleProduct
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationAddTierPriceToSimpleProduct
		$I->comment("Exiting Action Group [addTierPriceToSimpleProduct] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [openConfigurableProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenConfigurableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenConfigurableProductPage
		$I->comment("Exiting Action Group [openConfigurableProductPage] StorefrontOpenProductPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForConfigurableProductPage
		$I->comment("Entering Action Group [selectWhiteOption] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->click("div.swatch-option[data-option-label='White']"); // stepKey: clickSwatchOptionSelectWhiteOption
		$I->comment("Exiting Action Group [selectWhiteOption] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductTierPriceText] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$tierPriceTextAssertProductTierPriceText = $I->grabTextFrom(".prices-tier li[class='item']"); // stepKey: tierPriceTextAssertProductTierPriceText
		$I->assertEquals("Buy 5 for $61.50 each and save 50%", $tierPriceTextAssertProductTierPriceText); // stepKey: assertTierPriceTextOnProductPageAssertProductTierPriceText
		$I->comment("Exiting Action Group [assertProductTierPriceText] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$I->comment("Entering Action Group [addConfigurableProductToTheCart] StorefrontAddProductWithSwatchesTextOptionToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddConfigurableProductToTheCart
		$I->click("div.swatch-option[data-option-label='Blue']"); // stepKey: clickSwatchOptionAddConfigurableProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddConfigurableProductToTheCartWaitForPageLoad
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddConfigurableProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddConfigurableProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToTheCart] StorefrontAddProductWithSwatchesTextOptionToTheCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [updateCartItem] StorefrontUpdateCartItemEditParametersProductActionGroup");
		$I->click(".item:nth-of-type(1) .action-edit"); // stepKey: clickEditConfigurableProductButtonUpdateCartItem
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadUpdateCartItem
		$I->comment("Exiting Action Group [updateCartItem] StorefrontUpdateCartItemEditParametersProductActionGroup");
		$I->comment("Entering Action Group [selectWhiteOption2] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->click("div.swatch-option[data-option-label='White']"); // stepKey: clickSwatchOptionSelectWhiteOption2
		$I->comment("Exiting Action Group [selectWhiteOption2] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductTierPriceText2] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$tierPriceTextAssertProductTierPriceText2 = $I->grabTextFrom(".prices-tier li[class='item']"); // stepKey: tierPriceTextAssertProductTierPriceText2
		$I->assertEquals("Buy 5 for $61.50 each and save 50%", $tierPriceTextAssertProductTierPriceText2); // stepKey: assertTierPriceTextOnProductPageAssertProductTierPriceText2
		$I->comment("Exiting Action Group [assertProductTierPriceText2] AssertStorefrontProductDetailPageTierPriceActionGroup");
		$I->comment("Entering Action Group [selectWhiteOption3] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->click("div.swatch-option[data-option-label='Blue']"); // stepKey: clickSwatchOptionSelectWhiteOption3
		$I->comment("Exiting Action Group [selectWhiteOption3] StorefrontSelectSwatchOptionOnProductPageActionGroup");
		$I->dontSee(".prices-tier li[class='item']"); // stepKey: dontSeeTierPriceForOption
		$I->comment("Entering Action Group [addUpdatedConfigurableProductToTheCart] StorefrontAddProductWithSwatchesTextOptionToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddUpdatedConfigurableProductToTheCart
		$I->click("div.swatch-option[data-option-label='White']"); // stepKey: clickSwatchOptionAddUpdatedConfigurableProductToTheCart
		$I->fillField("input.input-text.qty", "10"); // stepKey: fillProduct1QuantityAddUpdatedConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddUpdatedConfigurableProductToTheCartWaitForPageLoad
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCartButtonAddUpdatedConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddUpdatedConfigurableProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddUpdatedConfigurableProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddUpdatedConfigurableProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddUpdatedConfigurableProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddUpdatedConfigurableProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addUpdatedConfigurableProductToTheCart] StorefrontAddProductWithSwatchesTextOptionToTheCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCartPage2] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage2
		$I->comment("Exiting Action Group [openShoppingCartPage2] StorefrontCartPageOpenActionGroup");
	}
}
