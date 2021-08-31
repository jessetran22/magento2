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
 * @Title("MC-75: Admin should be able to create a cart price rule for auto generated coupon codes")
 * @Description("Admin should be able to create a cart price rule for auto generated coupon codes<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateCartPriceRuleForGeneratedCouponTest.xml<br>")
 * @TestCaseId("MC-75")
 * @group SalesRule
 */
class AdminCreateCartPriceRuleForGeneratedCouponTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
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
		$I->comment("Delete the cart price rule we made during the test");
		$I->comment("Entering Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCleanUpRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCleanUpRule
		$I->fillField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: filterByNameCleanUpRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterCleanUpRule
		$I->waitForPageLoad(30); // stepKey: doFilterCleanUpRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageCleanUpRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageCleanUpRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonCleanUpRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonCleanUpRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteCleanUpRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteCleanUpRuleWaitForPageLoad
		$I->comment("Exiting Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->comment("Entering Action Group [deleteProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
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
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCartPriceRuleForGeneratedCouponTest(AcceptanceTester $I)
	{
		$I->comment("Create a cart price rule");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillRuleName
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsites
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroup
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->checkOption("input[name='use_auto_generation']"); // stepKey: tickAutoGeneration
		$date = new \DateTime();
		$date->setTimestamp(strtotime("-1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$yesterdayDate = $date->format("m/d/Y");

		$I->fillField("input[name='from_date']", $yesterdayDate); // stepKey: fillFromDate
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "0.99"); // stepKey: fillDiscountAmount
		$I->click("#save_and_continue"); // stepKey: clickSaveAndContinueButton
		$I->waitForPageLoad(30); // stepKey: clickSaveAndContinueButtonWaitForPageLoad
		$I->comment("Generate some coupon codes");
		$I->click("div[data-index='manage_coupon_codes']"); // stepKey: expandCouponSection
		$I->waitForPageLoad(30); // stepKey: expandCouponSectionWaitForPageLoad
		$I->fillField("#coupons_qty", "10"); // stepKey: fillCouponQty
		$I->click("#coupons_generate_button"); // stepKey: clickGenerate
		$I->waitForPageLoad(30); // stepKey: clickGenerateWaitForPageLoad
		$I->see("Message is added to queue, wait to get your coupons soon", "div.message.message-success.success"); // stepKey: seeGenerationSuccess
		$I->comment("Apply changes");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start codegeneratorProcessor --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->click("div[data-index='manage_coupon_codes']"); // stepKey: expandCouponSection2
		$I->waitForPageLoad(30); // stepKey: expandCouponSection2WaitForPageLoad
		$I->comment("Assert coupon codes grid header is correct");
		$I->see("Used", "#couponCodesGrid thead th[data-sort='used']"); // stepKey: seeCorrectUsedHeader
		$I->comment("Grab a coupon code and hold on to it for later");
		$grabCouponCode = $I->grabTextFrom("#couponCodesGrid_table > tbody > tr:nth-child(1) > td.col-code"); // stepKey: grabCouponCode
		$I->comment("Create a product to check the storefront");
		$I->comment("Entering Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFillProductFieldsInAdmin
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownFillProductFieldsInAdminWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddSimpleProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAddSimpleProductFillProductFieldsInAdminWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityFillProductFieldsInAdmin
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityFillProductFieldsInAdmin
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createPreReqCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryFillProductFieldsInAdminWaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionFillProductFieldsInAdminWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyFillProductFieldsInAdmin
		$I->click("#save-button"); // stepKey: saveProductFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: saveProductFillProductFieldsInAdminWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: assertFieldNameFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: assertFieldSkuFillProductFieldsInAdmin
		$I->seeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: assertFieldPriceFillProductFieldsInAdmin
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionAssertFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: openSeoSectionAssertFillProductFieldsInAdminWaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: assertFieldUrlKeyFillProductFieldsInAdmin
		$I->comment("Exiting Action Group [fillProductFieldsInAdmin] FillAdminSimpleProductFormActionGroup");
		$I->comment("Spot check the storefront");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeader
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponField
		$I->fillField("#coupon_code", $grabCouponCode); // stepKey: fillCouponField
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButton
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonWaitForPageLoad
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountTotal
		$I->see("-$0.99", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountTotal
		$I->comment("Exiting Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
	}
}
