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
 * @Title("MC-15450: Delete Active Sales Rule With Complex Conditions And Verify Delete Message")
 * @Description("Test log in to Cart Price Rule and Delete Active Sales Rule With Complex Conditions Test<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminDeleteActiveSalesRuleWithComplexConditionsAndVerifyDeleteMessageTest.xml<br>")
 * @TestCaseId("MC-15450")
 * @group salesRule
 * @group mtf_migrated
 */
class AdminDeleteActiveSalesRuleWithComplexConditionsAndVerifyDeleteMessageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create active cart price rule");
		$I->comment("Entering Action Group [createActiveCartPriceRuleRuleInfoSection] AdminCreateCartPriceRuleRuleInfoSectionActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateActiveCartPriceRuleRuleInfoSection
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateActiveCartPriceRuleRuleInfoSection
		$I->click("#add"); // stepKey: clickAddNewRuleCreateActiveCartPriceRuleRuleInfoSection
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateActiveCartPriceRuleRuleInfoSectionWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule with complex conditions" . msq("ActiveSalesRuleWithComplexConditions")); // stepKey: fillRuleNameCreateActiveCartPriceRuleRuleInfoSection
		$I->fillField("//div[@class='admin__field-control']/textarea[@name='description']", "Cart Price Rule with complex conditions"); // stepKey: fillDescriptionCreateActiveCartPriceRuleRuleInfoSection
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateActiveCartPriceRuleRuleInfoSection
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN',  'General',  'Wholesale',  'Retailer']); // stepKey: selectCustomerGroupCreateActiveCartPriceRuleRuleInfoSection
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponTypeCreateActiveCartPriceRuleRuleInfoSection
		$I->waitForElementVisible("input[name='coupon_code']", 30); // stepKey: waitForElementVisibleCreateActiveCartPriceRuleRuleInfoSection
		$I->fillField("input[name='coupon_code']", "123-abc-ABC-987" . msq("ActiveSalesRuleWithComplexConditions")); // stepKey: fillCouponCodeCreateActiveCartPriceRuleRuleInfoSection
		$I->fillField("//input[@name='uses_per_coupon']", "13"); // stepKey: fillUsesPerCouponCreateActiveCartPriceRuleRuleInfoSection
		$I->fillField("//input[@name='uses_per_customer']", "63"); // stepKey: fillUsesPerCustomerCreateActiveCartPriceRuleRuleInfoSection
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 minute"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$startDateTimeCreateActiveCartPriceRuleRuleInfoSection = $date->format("m/d/Y");

		$I->fillField("input[name='from_date']", $startDateTimeCreateActiveCartPriceRuleRuleInfoSection); // stepKey: fillStartDateCreateActiveCartPriceRuleRuleInfoSection
		$I->fillField("//*[@name='sort_order']", "1"); // stepKey: fillPriorityCreateActiveCartPriceRuleRuleInfoSection
		$I->conditionalClick("//div[@class='admin__actions-switch']/input[@name='is_rss']/../label", "//div[@class='admin__actions-switch']/input[@name='is_rss']/../label", false); // stepKey: clickOnlyIfRSSIsDisabledCreateActiveCartPriceRuleRuleInfoSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleRuleInfoSection] AdminCreateCartPriceRuleRuleInfoSectionActionGroup");
		$I->comment("Expand the conditions section");
		$I->conditionalClick("div[data-index='conditions']", "div[data-index='conditions']", true); // stepKey: clickToExpandConditions
		$I->waitForPageLoad(30); // stepKey: clickToExpandConditionsWaitForPageLoad
		$I->comment("Fill condition 1: Subtotal");
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickNewCondition1
		$I->waitForPageLoad(30); // stepKey: clickNewCondition1WaitForPageLoad
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Subtotal"); // stepKey: selectCondition1
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoad1
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsis1
		$I->fillField("[id='conditions__1--1__value']", "300"); // stepKey: fillSubtotalParameter1
		$I->comment("Fill condition 2: Country");
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickNewCondition2
		$I->waitForPageLoad(30); // stepKey: clickNewCondition2WaitForPageLoad
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Shipping Country"); // stepKey: selectCondition2
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoad2
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsis2
		$I->selectOption("(//*[contains(@value,'country_id')]/..//select)[last()]", "US"); // stepKey: fillShippingCountryParameter2
		$I->comment("Fill condition 3: Shipping Postcode");
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickNewCondition3
		$I->waitForPageLoad(30); // stepKey: clickNewCondition3WaitForPageLoad
		$I->selectOption("select[name='rule[conditions][1][new_child]']", "Shipping Postcode"); // stepKey: selectCondition3
		$I->waitForPageLoad(30); // stepKey: waitForConditionLoad3
		$I->click("//ul[contains(@id, 'conditions')]//a[.='...']"); // stepKey: clickEllipsis3
		$I->fillField("[id='conditions__1--3__value']", "123456789a"); // stepKey: fillShippingPostcodeParameter
		$I->comment("Fill values for Action Section");
		$I->comment("Entering Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->conditionalClick("div[data-index='actions']", "div[data-index='actions']", true); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleActionsSectionWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_qty']", "0"); // stepKey: fillMaximumQtyDiscountCreateActiveCartPriceRuleActionsSection
		$I->fillField("input[name='discount_step']", "0"); // stepKey: fillDiscountStepCreateActiveCartPriceRuleActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleActionsSection] AdminCreateCartPriceRuleActionsSectionDiscountFieldsActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleShippingAmountActionsSection] AdminCreateCartPriceRuleActionsSectionShippingAmountActionGroup");
		$I->click("//div[@class='admin__actions-switch']/input[@name='apply_to_shipping']/../label"); // stepKey: clickApplyToShippingCreateActiveCartPriceRuleShippingAmountActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleShippingAmountActionsSection] AdminCreateCartPriceRuleActionsSectionShippingAmountActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleDiscardSubsequentRulesActionsSection] AdminCreateCartPriceRuleActionsSectionSubsequentRulesActionGroup");
		$I->click("//div[@class='admin__actions-switch']/input[@name='stop_rules_processing']/../label"); // stepKey: clickApplyToShippingCreateActiveCartPriceRuleDiscardSubsequentRulesActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleDiscardSubsequentRulesActionsSection] AdminCreateCartPriceRuleActionsSectionSubsequentRulesActionGroup");
		$I->comment("Entering Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->selectOption("//select[@name='simple_free_shipping']", "For matching items only"); // stepKey: selectForMatchingItemsOnlyCreateActiveCartPriceRuleFreeShippingActionsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleFreeShippingActionsSection] AdminCreateCartPriceRuleActionsSectionFreeShippingActionGroup");
		$I->comment("Fill values for Labels Section");
		$I->comment("Entering Action Group [createActiveCartPriceRuleLabelsSection] AdminCreateCartPriceRuleLabelsSectionActionGroup");
		$I->conditionalClick("div[data-index='labels']", "div[data-index='labels']", true); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSection
		$I->waitForPageLoad(30); // stepKey: clickToExpandLabelsCreateActiveCartPriceRuleLabelsSectionWaitForPageLoad
		$I->fillField("input[name='store_labels[0]']", "Cart Price Rule with complex conditions"); // stepKey: fillDefaultRuleLabelAllStoreViewsCreateActiveCartPriceRuleLabelsSection
		$I->fillField("input[name='store_labels[1]']", "Cart Price Rule with complex conditions"); // stepKey: fillDefaultStoreViewCreateActiveCartPriceRuleLabelsSection
		$I->comment("Exiting Action Group [createActiveCartPriceRuleLabelsSection] AdminCreateCartPriceRuleLabelsSectionActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 minute"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateStartDate = $date->format("m/d/Y");

		$I->fillField("input[name='from_date']", $generateStartDate); // stepKey: fillStartDate
		$I->comment("Entering Action Group [assertVerifyCartPriceRuleSuccessSaveMessage] AssertCartPriceRuleSuccessSaveMessageActionGroup");
		$I->click("#save"); // stepKey: clickSaveButtonAssertVerifyCartPriceRuleSuccessSaveMessage
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonAssertVerifyCartPriceRuleSuccessSaveMessageWaitForPageLoad
		$I->see("You saved the rule.", "div.message.message-success.success"); // stepKey: seeAssertSuccessSaveMessageAssertVerifyCartPriceRuleSuccessSaveMessage
		$I->comment("Exiting Action Group [assertVerifyCartPriceRuleSuccessSaveMessage] AssertCartPriceRuleSuccessSaveMessageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Stories({"Delete Sales Rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"SalesRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteActiveSalesRuleWithComplexConditionsAndVerifyDeleteMessageTest(AcceptanceTester $I)
	{
		$I->comment("Delete active cart price rule");
		$I->comment("Entering Action Group [deleteActiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteActiveCartPriceRule
		$I->fillField("input[name='name']", "Cart Price Rule with complex conditions" . msq("ActiveSalesRuleWithComplexConditions")); // stepKey: filterByNameDeleteActiveCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteActiveCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteActiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->comment("Go to grid and verify AssertCartPriceRuleIsNotPresentedInGrid");
		$I->comment("Entering Action Group [searchAndVerifyActiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchAndVerifyActiveCartPriceRuleNotInGridWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule with complex conditions" . msq("ActiveSalesRuleWithComplexConditions")); // stepKey: filterByNameSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: doFilterSearchAndVerifyActiveCartPriceRuleNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td"); // stepKey: seeAssertCartPriceRuleIsNotPresentedInGridSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->comment("Exiting Action Group [searchAndVerifyActiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
	}
}
