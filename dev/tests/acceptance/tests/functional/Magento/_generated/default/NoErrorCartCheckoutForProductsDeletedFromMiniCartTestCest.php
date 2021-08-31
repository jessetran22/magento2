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
 * @Title("MAGETWO-91451: Delete product from Checkout")
 * @Description("No error from cart should be thrown for product deleted from minicart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/NoErrorCartCheckoutForProductsDeletedFromMiniCartTest.xml<br>")
 * @TestCaseId("MAGETWO-91451")
 * @group checkout
 */
class NoErrorCartCheckoutForProductsDeletedFromMiniCartTestCest
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
		$I->comment("Simple product is created with price = 100");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createSimpleProductFields['price'] = "100.00";
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Checkout"})
	 * @Stories({"Delete product from Storefront checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NoErrorCartCheckoutForProductsDeletedFromMiniCartTest(AcceptanceTester $I)
	{
		$I->comment("Preconditions");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("open the minicart");
		$I->comment("Entering Action Group [clickShowMinicart1] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickShowMinicart1
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickShowMinicart1
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickShowMinicart1WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickShowMinicart1
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickShowMinicart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickShowMinicart1
		$I->comment("Exiting Action Group [clickShowMinicart1] StorefrontClickOnMiniCartActionGroup");
		$I->click(".action.viewcart"); // stepKey: editProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: editProductFromMiniCartWaitForPageLoad
		$I->comment("Entering Action Group [clickShowMinicart2] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickShowMinicart2
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickShowMinicart2
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickShowMinicart2WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickShowMinicart2
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickShowMinicart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickShowMinicart2
		$I->comment("Exiting Action Group [clickShowMinicart2] StorefrontClickOnMiniCartActionGroup");
		$I->click(".action.delete"); // stepKey: deleteMiniCartItem
		$I->waitForPageLoad(30); // stepKey: deleteMiniCartItemWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitFortheConfirmationModal
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessage
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDelete
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinish
		$I->dontSeeElement("//table[@id='shopping-cart-table']//tbody//tr[contains(@class,'item-actions')]//a[contains(@class,'action-delete')]"); // stepKey: dontSeeDeleteProductFromCheckoutCart
		$I->comment("Entering Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickCart
		$I->comment("Exiting Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCart
	}
}
