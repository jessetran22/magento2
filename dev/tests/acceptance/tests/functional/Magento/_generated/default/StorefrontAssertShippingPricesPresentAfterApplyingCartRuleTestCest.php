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
 * @Title("MC-42229: Assert that shipping methods prices will be correct after cart price rule applied")
 * @Description("Shipping method prices should be displayed correctly on checkout after applied cart price rule<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/StorefrontAssertShippingPricesPresentAfterApplyingCartRuleTest.xml<br>")
 * @TestCaseId("MC-42229")
 * @group shipping
 * @group SalesRule
 */
class StorefrontAssertShippingPricesPresentAfterApplyingCartRuleTestCest
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
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Entering Action Group [switchDefaultWebsite] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSwitchDefaultWebsite
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownSwitchDefaultWebsite
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleSwitchDefaultWebsite
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleSwitchDefaultWebsiteWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameSwitchDefaultWebsite
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameSwitchDefaultWebsiteWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchDefaultWebsite
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchDefaultWebsiteWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchDefaultWebsite
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchDefaultWebsiteWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameSwitchDefaultWebsite
		$I->comment("Exiting Action Group [switchDefaultWebsite] AdminSwitchWebsiteActionGroup");
		$I->comment("Entering Action Group [enableTableRatesShippingMethodForDefaultWebsite] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabEnableTableRatesShippingMethodForDefaultWebsite
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueEnableTableRatesShippingMethodForDefaultWebsite
		$I->selectOption("#carriers_tablerate_active", "1"); // stepKey: changeTableRatesMethodStatusEnableTableRatesShippingMethodForDefaultWebsite
		$I->comment("Exiting Action Group [enableTableRatesShippingMethodForDefaultWebsite] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->comment("Entering Action Group [importCSVFile] AdminImportFileTableRatesShippingMethodActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabImportCSVFile
		$I->attachFile("#carriers_tablerate_import", "usa_tablerates.csv"); // stepKey: attachFileForImportImportCSVFile
		$I->comment("Exiting Action Group [importCSVFile] AdminImportFileTableRatesShippingMethodActionGroup");
		$I->comment("Entering Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfig
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfig
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfig
		$I->comment("Exiting Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->comment("Entering Action Group [deleteAllExistingCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToAdminCartPriceRuleGridPageDeleteAllExistingCartPriceRules
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllExistingCartPriceRules
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllExistingCartPriceRules
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllExistingCartPriceRulesWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllExistingCartPriceRules] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllExistingCartPriceRules
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllExistingCartPriceRules
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllExistingCartPriceRules
		$I->comment("Exiting Action Group [deleteAllExistingCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [createCartPriceRule] AdminOpenNewCartPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/new/"); // stepKey: openNewCartPriceRulePageCreateCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCreateCartPriceRule
		$I->comment("Exiting Action Group [createCartPriceRule] AdminOpenNewCartPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillCartPriceRuleMainInfo] AdminCartPriceRuleFillMainInfoActionGroup");
		$I->fillField("input[name='name']", "Cart Price Rule For Rule Condition" . msq("CartPriceRuleConditionForSubtotalForMultiShipping")); // stepKey: fillNameFillCartPriceRuleMainInfo
		$I->fillField("//div[@class='admin__field-control']/textarea[@name='description']", "Description for Cart Price Rule"); // stepKey: fillDescriptionFillCartPriceRuleMainInfo
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillCartPriceRuleMainInfo
		$I->selectOption("select[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillCartPriceRuleMainInfo
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN', 'General', 'Wholesale', 'Retailer']); // stepKey: selectSpecifiedCustomerGroupsFillCartPriceRuleMainInfo
		$I->fillField("input[name='from_date']", ""); // stepKey: fillFromDateFillCartPriceRuleMainInfo
		$I->fillField("input[name='to_date']", ""); // stepKey: fillToDateFillCartPriceRuleMainInfo
		$I->fillField("//*[@name='sort_order']", ""); // stepKey: fillPriorityFillCartPriceRuleMainInfo
		$I->comment("Exiting Action Group [fillCartPriceRuleMainInfo] AdminCartPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillCartPriceRuleCouponInfo] AdminCartPriceRuleFillCouponInfoActionGroup");
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponTypeFillCartPriceRuleCouponInfo
		$I->fillField("input[name='coupon_code']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillCouponCodeFillCartPriceRuleCouponInfo
		$I->fillField("//input[@name='uses_per_coupon']", "500"); // stepKey: setUserPerCouponFillCartPriceRuleCouponInfo
		$I->fillField("//input[@name='uses_per_customer']", "1"); // stepKey: setUserPerCustomerFillCartPriceRuleCouponInfo
		$I->comment("Exiting Action Group [fillCartPriceRuleCouponInfo] AdminCartPriceRuleFillCouponInfoActionGroup");
		$I->comment("Entering Action Group [setCartAttributeConditionForCartPriceRule] AdminCartPriceRuleFillShippingConditionActionGroup");
		$I->click("div[data-index='conditions']"); // stepKey: openConditionsSectionSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: openConditionsSectionSetCartAttributeConditionForCartPriceRuleWaitForPageLoad
		$I->click("//*[@id='conditions__1__children']//span"); // stepKey: addConditionSetCartAttributeConditionForCartPriceRule
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Shipping Method"); // stepKey: specifyConditionSetCartAttributeConditionForCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoadSetCartAttributeConditionForCartPriceRule
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsisSetCartAttributeConditionForCartPriceRule
		$I->selectOption("[id='conditions__1--1__value']", "[flatrate] Fixed"); // stepKey: selectShippingMethodSetCartAttributeConditionForCartPriceRule
		$I->comment("Exiting Action Group [setCartAttributeConditionForCartPriceRule] AdminCartPriceRuleFillShippingConditionActionGroup");
		$I->comment("Entering Action Group [fillCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickToExpandActionsFillCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsFillCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeFillCartPriceRuleActionsSection
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountFillCartPriceRuleActionsSection
		$I->fillField("input[name='discount_qty']", "0"); // stepKey: fillMaximumQtyDiscountFillCartPriceRuleActionsSection
		$I->fillField("input[name='discount_step']", "0"); // stepKey: fillDiscountStepFillCartPriceRuleActionsSection
		$I->comment("Exiting Action Group [fillCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->comment("Entering Action Group [fillCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->selectOption("//select[@name='simple_free_shipping']", "For matching items only"); // stepKey: selectForMatchingItemsOnlyFillCartPriceRuleFreeShippingActionsSection
		$I->comment("Exiting Action Group [fillCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->comment("Entering Action Group [saveCartPriceRule] AdminCartPriceRuleSaveActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveCartPriceRule
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveCartPriceRuleWaitForPageLoad
		$I->click("#save"); // stepKey: saveRuleSaveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: saveRuleSaveCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCartPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveCartPriceRule
		$I->comment("Exiting Action Group [saveCartPriceRule] AdminCartPriceRuleSaveActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: goToAdminCartPriceRuleGridPageDeleteAllCartPriceRules
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCartPriceRules
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCartPriceRules
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCartPriceRulesWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCartPriceRules] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCartPriceRules
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCartPriceRules
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCartPriceRules
		$I->comment("Exiting Action Group [deleteAllCartPriceRules] AdminCartPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [openShippingMethodConfigPage2] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage2
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage2
		$I->comment("Exiting Action Group [openShippingMethodConfigPage2] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Entering Action Group [switchDefaultWebsite2] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSwitchDefaultWebsite2
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownSwitchDefaultWebsite2
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleSwitchDefaultWebsite2
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleSwitchDefaultWebsite2WaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameSwitchDefaultWebsite2
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameSwitchDefaultWebsite2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchDefaultWebsite2
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchDefaultWebsite2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchDefaultWebsite2
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchDefaultWebsite2WaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameSwitchDefaultWebsite2
		$I->comment("Exiting Action Group [switchDefaultWebsite2] AdminSwitchWebsiteActionGroup");
		$I->comment("Entering Action Group [disableTableRatesShippingMethodForDefaultWebsite] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabDisableTableRatesShippingMethodForDefaultWebsite
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueDisableTableRatesShippingMethodForDefaultWebsite
		$I->selectOption("#carriers_tablerate_active", "0"); // stepKey: changeTableRatesMethodStatusDisableTableRatesShippingMethodForDefaultWebsite
		$I->comment("Exiting Action Group [disableTableRatesShippingMethodForDefaultWebsite] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->comment("Entering Action Group [saveConfig2] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfig2
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfig2
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfig2
		$I->comment("Exiting Action Group [saveConfig2] AdminSaveConfigActionGroup");
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
	 * @Features({"Shipping"})
	 * @Stories({"Cart price rules"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAssertShippingPricesPresentAfterApplyingCartRuleTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageNavigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailFieldGuestCheckoutFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: fillFirstNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "[\"7700 W Parmer Ln\",\"Bld D\"]"); // stepKey: fillStreetGuestCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: fillCityGuestCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: fillZipCodeGuestCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: fillPhoneGuestCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSection] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->see("$5.00", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Fixed')]/..//td//span[contains(@class, 'price')]"); // stepKey: assertFlatRatedMethodPrice
		$I->see("$7.99", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Table Rate')]/..//td//span[contains(@class, 'price')]"); // stepKey: assertTableRatedMethodPrice
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethod
		$I->comment("Entering Action Group [goToPaymentStep] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToPaymentStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToPaymentStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonGoToPaymentStep
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonGoToPaymentStepWaitForPageLoad
		$I->comment("Exiting Action Group [goToPaymentStep] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Entering Action Group [applyCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountApplyCoupon
		$I->fillField("#discount-code", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillFieldDiscountCodeApplyCoupon
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountApplyCoupon
		$I->waitForElementVisible(".message-success div", 30); // stepKey: waitForDiscountToBeAddedApplyCoupon
		$I->see("Your coupon was successfully applied", ".message-success div"); // stepKey: assertDiscountApplyMessageApplyCoupon
		$I->comment("Exiting Action Group [applyCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->comment("Entering Action Group [amOnHomePageAfterCartRuleApplied] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePageAfterCartRuleApplied
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePageAfterCartRuleApplied
		$I->comment("Exiting Action Group [amOnHomePageAfterCartRuleApplied] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart2
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart2
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart2
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicart2WaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart2
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicart2WaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart2] GoToCheckoutFromMinicartActionGroup");
		$I->see("$0.00", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Fixed')]/..//td//span[contains(@class, 'price')]"); // stepKey: assertFlatRatedMethodPriceAfterCartRule
		$I->see("$7.99", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Table Rate')]/..//td//span[contains(@class, 'price')]"); // stepKey: assertTableRatedMethodPriceAfterCartRule
	}
}
