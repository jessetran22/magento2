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
 * @Title("MC-79: Customer should not see the catalog price rule promotion if status is inactive")
 * @Description("Customer should not see the catalog price rule promotion if status is inactive<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/StorefrontInactiveCatalogRuleTest.xml<br>")
 * @TestCaseId("MC-79")
 * @group catalogRule
 */
class StorefrontInactiveCatalogRuleTestCest
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
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingFirstPriceRule
		$I->comment("Exiting Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForFirstPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForFirstPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='0']+label", false); // stepKey: fillActiveFillMainInfoForFirstPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForFirstPriceRule
		$I->selectOption("[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForFirstPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForFirstPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForThirdPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForThirdPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForThirdPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForThirdPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountAmountFillActionsForThirdPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForThirdPriceRule
		$I->comment("Exiting Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [saveAndApplyFirstPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplyFirstPriceRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonSaveAndApplyFirstPriceRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleSaveAndApplyFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleSaveAndApplyFirstPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveAndApplyFirstPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageSaveAndApplyFirstPriceRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageSaveAndApplyFirstPriceRule
		$I->comment("Exiting Action Group [saveAndApplyFirstPriceRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: filterByRuleNameDeleteCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteCatalogPriceRule
		$I->comment("Exiting Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"CatalogRule"})
	 * @Stories({"Customer view catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontInactiveCatalogRuleTest(AcceptanceTester $I)
	{
		$I->comment("Verify price is not discounted on category page");
		$I->comment("Entering Action Group [openCategoryPageOnFrontend] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategoryPageOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategoryPageOnFrontend
		$I->comment("Exiting Action Group [openCategoryPageOnFrontend] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductPriceOnCategoryPage] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeProductPriceSeeProductPriceOnCategoryPage
		$I->comment("Exiting Action Group [seeProductPriceOnCategoryPage] StorefrontAssertProductPriceOnCategoryPageActionGroup");
		$I->comment("Verify price is not discounted on the product page");
		$I->comment("Entering Action Group [openProductPageOnFrontend] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPageOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPageOnFrontend
		$I->comment("Exiting Action Group [openProductPageOnFrontend] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seePriceOnProductPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeePriceOnProductPage
		$I->comment("Exiting Action Group [seePriceOnProductPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Verify price is not discounted in the cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCartPage
		$I->comment("Exiting Action Group [openCartPage] StorefrontCartPageOpenActionGroup");
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalAppears
		$I->comment("Entering Action Group [seeProductPriceOnCartPage] AssertStorefrontCheckoutPaymentSummarySubtotalActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCartFullyLoadedSeeProductPriceOnCartPage
		$I->waitForElementVisible("//tr[@class='totals sub']//span[@class='price']", 30); // stepKey: waitForOrderSummaryBlockSeeProductPriceOnCartPage
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//tr[@class='totals sub']//span[@class='price']"); // stepKey: seeCorrectSubtotalSeeProductPriceOnCartPage
		$I->comment("Exiting Action Group [seeProductPriceOnCartPage] AssertStorefrontCheckoutPaymentSummarySubtotalActionGroup");
	}
}
