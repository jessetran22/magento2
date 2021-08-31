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
 * @Title("MC-14694: Delete grouped product from shopping cart test")
 * @Description("Delete grouped product from shopping cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/DeleteGroupedProductFromShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14694")
 * @group checkout
 * @group mtf_migrated
 */
class DeleteGroupedProductFromShoppingCartTestCest
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
		$I->comment("Create grouped product with three simple products");
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondSimpleProduct
		$I->createEntity("createThirdSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createThirdSimpleProduct
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("addFirstProductToLink", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createFirstSimpleProduct"], []); // stepKey: addFirstProductToLink
		$I->updateEntity("addFirstProductToLink", "hook", "OneMoreSimpleProductLink",["createGroupedProduct", "createSecondSimpleProduct"]); // stepKey: addSecondProductTwo
		$I->updateEntity("addFirstProductToLink", "hook", "OneMoreSimpleProductLink",["createGroupedProduct", "createThirdSimpleProduct"]); // stepKey: addThirdProductThree
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete grouped product data");
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdSimpleProduct", "hook"); // stepKey: deleteThirdProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
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
	 * @Stories({"Delete Products from Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteGroupedProductFromShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add grouped product to the cart");
		$I->comment("Entering Action Group [addGropedProductsToTheCart] StorefrontAddThreeGroupedProductToTheCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPageAddGropedProductsToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForProduct1AddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForProduct2AddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('createThirdSimpleProduct', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForProduct3AddGropedProductsToTheCart
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCartButtonAddGropedProductsToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddGropedProductsToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addGropedProductsToTheCart] StorefrontAddThreeGroupedProductToTheCartActionGroup");
		$I->comment("Remove products from cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createFirstSimpleProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteFirstProductFromCheckoutCart
		$I->waitForPageLoad(30); // stepKey: deleteFirstProductFromCheckoutCartWaitForPageLoad
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createSecondSimpleProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteSecondProductFromCheckoutCart
		$I->waitForPageLoad(30); // stepKey: deleteSecondProductFromCheckoutCartWaitForPageLoad
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createThirdSimpleProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteThirdProductFromCheckoutCart
		$I->waitForPageLoad(30); // stepKey: deleteThirdProductFromCheckoutCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCart
	}
}
