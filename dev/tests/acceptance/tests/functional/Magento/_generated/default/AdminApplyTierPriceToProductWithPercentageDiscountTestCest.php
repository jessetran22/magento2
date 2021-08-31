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
 * @Title("MAGETWO-96881: You should be able to apply tier price to a product with float percent discount.")
 * @Description("You should be able to apply tier price to a product with float percent discount.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminApplyTierPriceToProductTest/AdminApplyTierPriceToProductWithPercentageDiscountTest.xml<br>")
 * @TestCaseId("MAGETWO-96881")
 * @group product
 */
class AdminApplyTierPriceToProductWithPercentageDiscountTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "100";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [loginAsAdminInBefore] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminInBefore
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminInBefore
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminInBefore
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminInBefore
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminInBeforeWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminInBefore
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminInBefore
		$I->comment("Exiting Action Group [loginAsAdminInBefore] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"MC-5517 - System tries to save 0 in Advanced Pricing which is invalid for Discount field"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyTierPriceToProductWithPercentageDiscountTest(AcceptanceTester $I)
	{
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [clickOnAdvancedPricingButtonForAssert] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkClickOnAdvancedPricingButtonForAssert
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkClickOnAdvancedPricingButtonForAssertWaitForPageLoad
		$I->waitForElementVisible("aside.product_form_product_form_advanced_pricing_modal h1.modal-title", 30); // stepKey: waitForModalTitleAppearsClickOnAdvancedPricingButtonForAssert
		$I->see("Advanced Pricing", "aside.product_form_product_form_advanced_pricing_modal h1.modal-title"); // stepKey: checkModalTitleClickOnAdvancedPricingButtonForAssert
		$I->comment("Exiting Action Group [clickOnAdvancedPricingButtonForAssert] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->comment("Entering Action Group [assertProductTierPriceInput] AssertAdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForGroupPriceAddButtonAppearsAssertProductTierPriceInput
		$I->waitForPageLoad(30); // stepKey: waitForGroupPriceAddButtonAppearsAssertProductTierPriceInputWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickCustomerGroupPriceAddButtonAssertProductTierPriceInput
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonAssertProductTierPriceInputWaitForPageLoad
		$I->waitForElementVisible("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[website_id]']", 30); // stepKey: waitForPriceWebsiteInputAppearsAssertProductTierPriceInput
		$priceAmountSelectorAssertProductTierPriceInput = $I->executeJS("return 'Fixed' == 'Discount' ? \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[percentage_value]']\" : \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[price]']\""); // stepKey: priceAmountSelectorAssertProductTierPriceInput
		$I->waitForElementVisible($priceAmountSelectorAssertProductTierPriceInput, 30); // stepKey: waitPriceAmountFieldAppersAssertProductTierPriceInput
		$priceMinWidthAssertProductTierPriceInput = $I->executeJS("return window.getComputedStyle(document.querySelector(\"{$priceAmountSelectorAssertProductTierPriceInput}\")).getPropertyValue('min-width')"); // stepKey: priceMinWidthAssertProductTierPriceInput
		$I->assertEquals("60px", "$priceMinWidthAssertProductTierPriceInput"); // stepKey: assertWebsiteAmountsAssertProductTierPriceInput
		$I->click("[data-action='remove_row']"); // stepKey: clickCustomerGroupPriceDeleteButtonAssertProductTierPriceInput
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceDeleteButtonAssertProductTierPriceInputWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductTierPriceInput] AssertAdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->comment("Entering Action Group [doneButtonAfterAssert] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageDoneButtonAfterAssert
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonDoneButtonAfterAssert
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonDoneButtonAfterAssertWaitForPageLoad
		$I->comment("Exiting Action Group [doneButtonAfterAssert] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickOnAdvancedPricingButton] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkClickOnAdvancedPricingButton
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkClickOnAdvancedPricingButtonWaitForPageLoad
		$I->waitForElementVisible("aside.product_form_product_form_advanced_pricing_modal h1.modal-title", 30); // stepKey: waitForModalTitleAppearsClickOnAdvancedPricingButton
		$I->see("Advanced Pricing", "aside.product_form_product_form_advanced_pricing_modal h1.modal-title"); // stepKey: checkModalTitleClickOnAdvancedPricingButton
		$I->comment("Exiting Action Group [clickOnAdvancedPricingButton] AdminProductFormOpenAdvancedPricingDialogActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [selectProductTierPricePriceInput] AdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForGroupPriceAddButtonAppearsSelectProductTierPricePriceInput
		$I->waitForPageLoad(30); // stepKey: waitForGroupPriceAddButtonAppearsSelectProductTierPricePriceInputWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickCustomerGroupPriceAddButtonSelectProductTierPricePriceInput
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonSelectProductTierPricePriceInputWaitForPageLoad
		$I->waitForElementVisible("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[website_id]']", 30); // stepKey: waitForPriceWebsiteInputAppearsSelectProductTierPricePriceInput
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[website_id]']", "All Websites [USD]"); // stepKey: selectWebsiteSelectProductTierPricePriceInput
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[cust_group]']", "ALL GROUPS"); // stepKey: selectCustomerGroupSelectProductTierPricePriceInput
		$I->fillField("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[price_qty]']", "1"); // stepKey: fillQuantitySelectProductTierPricePriceInput
		$I->selectOption("[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[value_type]']", "Discount"); // stepKey: selectPriceTypeSelectProductTierPricePriceInput
		$priceAmountSelectorSelectProductTierPricePriceInput = $I->executeJS("return 'Discount' == 'Discount' ? \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[percentage_value]']\" : \"[data-index='tier_price'] table tbody tr.data-row:last-child [name*='[price]']\""); // stepKey: priceAmountSelectorSelectProductTierPricePriceInput
		$I->waitForElementVisible($priceAmountSelectorSelectProductTierPricePriceInput, 30); // stepKey: waitPriceAmountFieldAppersSelectProductTierPricePriceInput
		$I->fillField($priceAmountSelectorSelectProductTierPricePriceInput, "0.1"); // stepKey: fillPriceAmountSelectProductTierPricePriceInput
		$I->comment("Exiting Action Group [selectProductTierPricePriceInput] AdminProductFormAdvancedPricingAddTierPriceActionGroup");
		$I->comment("Entering Action Group [clickDoneButton] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageClickDoneButton
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonClickDoneButton
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonClickDoneButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickDoneButton] AdminProductFormDoneAdvancedPricingDialogActionGroup");
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goProductPageOnStorefront] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoProductPageOnStorefront
		$I->comment("Exiting Action Group [goProductPageOnStorefront] StorefrontOpenProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'99.90')]"); // stepKey: assertProductFinalPriceProductPage
		$I->seeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceProductPage
		$I->seeElement("//span[@data-price-type='oldPrice']//span[@class='price'][contains(., '100')]"); // stepKey: assertRegularPriceAmountProductPage
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->seeElement("//span[@data-price-type='finalPrice']//span[@class='price'][contains(.,'99.90')]"); // stepKey: assertProductFinalPriceCategoryPage
		$I->seeElement("//span[@class='price-label'][contains(text(),'Regular Price')]"); // stepKey: assertRegularPriceLabelCategoryPage
		$I->seeElement("//span[@data-price-type='oldPrice']//span[@class='price'][contains(., '100')]"); // stepKey: assertRegularPriceAmountCategoryPage
	}
}
