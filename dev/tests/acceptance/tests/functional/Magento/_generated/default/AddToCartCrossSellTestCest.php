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
 * @Title("MC-9143: Admin should be able to add cross-sell to products.")
 * @Description("Create products, add products to cross sells, and check that they appear in the Shopping Cart page.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AddToCartCrossSellTest.xml<br>")
 * @TestCaseId("MC-9143")
 * @group Catalog
 */
class AddToCartCrossSellTestCest
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
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("simpleProduct1", "hook", "_defaultProduct", ["category1"], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "_defaultProduct", ["category1"], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "_defaultProduct", ["category1"], []); // stepKey: simpleProduct3
		$I->comment("Entering Action Group [logInAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogInAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogInAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogInAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogInAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogInAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogInAsAdmin
		$I->comment("Exiting Action Group [logInAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimp1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimp2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimp3
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Promote Products as Cross-Sells"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AddToCartCrossSellTest(AcceptanceTester $I)
	{
		$I->comment("Go to simpleProduct1, add simpleProduct2 and simpleProduct3 as cross-sell");
		$I->comment("Entering Action Group [goToProduct1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct1', 'id', 'test')); // stepKey: goToProductGoToProduct1
		$I->comment("Exiting Action Group [goToProduct1] AdminProductPageOpenByIdActionGroup");
		$I->click(".fieldset-wrapper.admin__collapsible-block-wrapper[data-index='related']"); // stepKey: openHeader1
		$I->comment("Entering Action Group [addProduct2ToSimp1] AddCrossSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: scrollToAddProduct2ToSimp1WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddProduct2ToSimp1
		$I->click("button[data-index='button_crosssell']"); // stepKey: clickAddCrossSellButtonAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickAddCrossSellButtonAddProduct2ToSimp1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddProduct2ToSimp1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddProduct2ToSimp1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterAddProduct2ToSimp1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddProduct2ToSimp1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProduct2ToSimp1
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: selectProductAddProduct2ToSimp1WaitForPageLoad
		$I->click(".product_form_product_form_related_crosssell_modal .action-primary"); // stepKey: addRelatedProductSelectedAddProduct2ToSimp1
		$I->waitForPageLoad(30); // stepKey: waitForModalDisappearAddProduct2ToSimp1
		$I->comment("Exiting Action Group [addProduct2ToSimp1] AddCrossSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [addProduct3ToSimp1] AddCrossSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: scrollToAddProduct3ToSimp1WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddProduct3ToSimp1
		$I->click("button[data-index='button_crosssell']"); // stepKey: clickAddCrossSellButtonAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickAddCrossSellButtonAddProduct3ToSimp1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddProduct3ToSimp1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddProduct3ToSimp1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct3', 'sku', 'test')); // stepKey: fillProductSkuFilterAddProduct3ToSimp1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddProduct3ToSimp1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProduct3ToSimp1
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: selectProductAddProduct3ToSimp1WaitForPageLoad
		$I->click(".product_form_product_form_related_crosssell_modal .action-primary"); // stepKey: addRelatedProductSelectedAddProduct3ToSimp1
		$I->waitForPageLoad(30); // stepKey: waitForModalDisappearAddProduct3ToSimp1
		$I->comment("Exiting Action Group [addProduct3ToSimp1] AddCrossSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSave
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSave
		$I->comment("Exiting Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->comment("Go to simpleProduct3, add simpleProduct1 and simpleProduct2 as cross-sell");
		$I->comment("Entering Action Group [goToProduct3] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct3', 'id', 'test')); // stepKey: goToProductGoToProduct3
		$I->comment("Exiting Action Group [goToProduct3] AdminProductPageOpenByIdActionGroup");
		$I->click(".fieldset-wrapper.admin__collapsible-block-wrapper[data-index='related']"); // stepKey: openHeader2
		$I->comment("Entering Action Group [addProduct1ToSimp3] AddCrossSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: scrollToAddProduct1ToSimp3WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddProduct1ToSimp3
		$I->click("button[data-index='button_crosssell']"); // stepKey: clickAddCrossSellButtonAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickAddCrossSellButtonAddProduct1ToSimp3WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddProduct1ToSimp3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddProduct1ToSimp3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterAddProduct1ToSimp3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddProduct1ToSimp3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProduct1ToSimp3
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: selectProductAddProduct1ToSimp3WaitForPageLoad
		$I->click(".product_form_product_form_related_crosssell_modal .action-primary"); // stepKey: addRelatedProductSelectedAddProduct1ToSimp3
		$I->waitForPageLoad(30); // stepKey: waitForModalDisappearAddProduct1ToSimp3
		$I->comment("Exiting Action Group [addProduct1ToSimp3] AddCrossSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [addProduct2ToSimp3] AddCrossSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: scrollToAddProduct2ToSimp3WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddProduct2ToSimp3
		$I->click("button[data-index='button_crosssell']"); // stepKey: clickAddCrossSellButtonAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickAddCrossSellButtonAddProduct2ToSimp3WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddProduct2ToSimp3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddProduct2ToSimp3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterAddProduct2ToSimp3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddProduct2ToSimp3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProduct2ToSimp3
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: selectProductAddProduct2ToSimp3WaitForPageLoad
		$I->click(".product_form_product_form_related_crosssell_modal .action-primary"); // stepKey: addRelatedProductSelectedAddProduct2ToSimp3
		$I->waitForPageLoad(30); // stepKey: waitForModalDisappearAddProduct2ToSimp3
		$I->comment("Exiting Action Group [addProduct2ToSimp3] AddCrossSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [clickSave2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSave2
		$I->waitForPageLoad(30); // stepKey: saveProductClickSave2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSave2
		$I->comment("Exiting Action Group [clickSave2] AdminProductFormSaveActionGroup");
		$I->comment("Go to frontend, add simpleProduct1 to cart");
		$I->comment("Entering Action Group [addSimp1ToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimp1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimp1ToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimp1ToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimp1ToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimp1ToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimp1ToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimp1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimp1ToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimp1ToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimp1ToCart
		$I->comment("Exiting Action Group [addSimp1ToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Check that cart page contains cross-sell to simpleProduct2 and simpleProduct3");
		$I->comment("Entering Action Group [goToCart1] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart1
		$I->comment("Exiting Action Group [goToCart1] StorefrontCartPageOpenActionGroup");
		$I->waitForElementVisible(".block.crosssell .block-content", 30); // stepKey: waitForCrossSellLoading
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".block.crosssell .block-content"); // stepKey: seeProduct2InCrossSell
		$I->see($I->retrieveEntityField('simpleProduct3', 'name', 'test'), ".block.crosssell .block-content"); // stepKey: seeProduct3InCrossSell
		$I->comment("Add simpleProduct3 to cart, check cross-sell contains product2 but not product3");
		$I->click("//li[@class='item product product-item'and .//a[@title='" . $I->retrieveEntityField('simpleProduct3', 'name', 'test') . "']]//button[@title='Add to Cart']"); // stepKey: addSimp3ToCart
		$I->waitForPageLoad(30); // stepKey: waitForCartToLoad2
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".block.crosssell .block-content"); // stepKey: seeProduct2StillInCrossSell
		$I->dontSee($I->retrieveEntityField('simpleProduct3', 'name', 'test'), ".block.crosssell .block-content"); // stepKey: dontSeeProduct3InCrossSell
		$I->comment("Add simpleProduct2 to cart, check cross-sell doesn't contain product 2 anymore.");
		$I->click("//li[@class='item product product-item'and .//a[@title='" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "']]//button[@title='Add to Cart']"); // stepKey: addSimp2ToCart
		$I->waitForPageLoad(30); // stepKey: waitForCartToLoad3
		$I->dontSee($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".block.crosssell .block-content"); // stepKey: dontSeeProduct2InCrossSell
	}
}
