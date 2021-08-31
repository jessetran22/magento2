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
 * @Title("MC-15451: Delete Inactive Sales Rule And Verify Delete Message")
 * @Description("Test log in to Cart Price Rule and Delete Inactive Sales Rule Test<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminDeleteInactiveSalesRuleAndVerifyDeleteMessageTest.xml<br>")
 * @TestCaseId("MC-15451")
 * @group salesRule
 * @group mtf_migrated
 */
class AdminDeleteInactiveSalesRuleAndVerifyDeleteMessageTestCest
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
		$I->createEntity("initialSimpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: initialSimpleProduct
		$I->comment("Create inactive cart price rule");
		$I->comment("Entering Action Group [createInactiveCartPriceRule] AdminInactiveCartPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateInactiveCartPriceRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateInactiveCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateInactiveCartPriceRule
		$I->fillField("input[name='name']", "Inactive Cart Price Rule" . msq("InactiveSalesRule")); // stepKey: fillRuleNameCreateInactiveCartPriceRule
		$I->click("//div[@class='admin__actions-switch']/input[@name='is_active']/../label"); // stepKey: clickActiveToDisableCreateInactiveCartPriceRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateInactiveCartPriceRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectCustomerGroupCreateInactiveCartPriceRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateInactiveCartPriceRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionTypeCreateInactiveCartPriceRule
		$I->fillField("input[name='discount_amount']", "50"); // stepKey: fillDiscountAmountCreateInactiveCartPriceRule
		$I->click("#save"); // stepKey: clickSaveButtonCreateInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateInactiveCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateInactiveCartPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateInactiveCartPriceRule
		$I->comment("Exiting Action Group [createInactiveCartPriceRule] AdminInactiveCartPriceRuleActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialSimpleProduct", "hook"); // stepKey: deleteProduct
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
	public function AdminDeleteInactiveSalesRuleAndVerifyDeleteMessageTest(AcceptanceTester $I)
	{
		$I->comment("Delete inactive cart price rule");
		$I->comment("Entering Action Group [deleteInactiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteInactiveCartPriceRule
		$I->fillField("input[name='name']", "Inactive Cart Price Rule" . msq("InactiveSalesRule")); // stepKey: filterByNameDeleteInactiveCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteInactiveCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteInactiveCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteInactiveCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteInactiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteInactiveCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteInactiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->comment("Go to grid and verify AssertCartPriceRuleIsNotPresentedInGrid");
		$I->comment("Entering Action Group [searchAndVerifyInactiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchAndVerifyInactiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchAndVerifyInactiveCartPriceRuleNotInGridWaitForPageLoad
		$I->fillField("input[name='name']", "Inactive Cart Price Rule" . msq("InactiveSalesRule")); // stepKey: filterByNameSearchAndVerifyInactiveCartPriceRuleNotInGrid
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterSearchAndVerifyInactiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: doFilterSearchAndVerifyInactiveCartPriceRuleNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchAndVerifyInactiveCartPriceRuleNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td"); // stepKey: seeAssertCartPriceRuleIsNotPresentedInGridSearchAndVerifyInactiveCartPriceRuleNotInGrid
		$I->comment("Exiting Action Group [searchAndVerifyInactiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
		$I->comment("Verify customer don't see updated virtual product link on category page");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('initialSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('initialSimpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Click on Add To Cart button");
		$I->comment("Entering Action Group [clickOnAddToCartButton] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnAddToCartButton
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonClickOnAddToCartButton
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonClickOnAddToCartButtonWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartClickOnAddToCartButton
		$I->waitForPageLoad(60); // stepKey: addToCartClickOnAddToCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnAddToCartButton
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageClickOnAddToCartButton
		$I->comment("Exiting Action Group [clickOnAddToCartButton] StorefrontAddToTheCartActionGroup");
		$I->comment("Click on mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Open mini cart and verify Shopping cart subtotal equals to grand total - price rule has not been applied.");
		$I->comment("Entering Action Group [verifyCartSubtotalEqualsGrandTotal] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$560.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartVerifyCartSubtotalEqualsGrandTotalWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('initialSimpleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1VerifyCartSubtotalEqualsGrandTotal
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageVerifyCartSubtotalEqualsGrandTotal
		$I->see("$560.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalVerifyCartSubtotalEqualsGrandTotal
		$I->see($I->retrieveEntityField('initialSimpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartVerifyCartSubtotalEqualsGrandTotal
		$I->comment("Exiting Action Group [verifyCartSubtotalEqualsGrandTotal] AssertStorefrontMiniCartItemsActionGroup");
	}
}
